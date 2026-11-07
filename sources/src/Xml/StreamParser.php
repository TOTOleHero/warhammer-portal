<?php

namespace App\Xml;

/**
 * Remplacement drop-in de Hobnob\XmlStreamReader\Parser, basÃĐ sur XMLReader.
 * MÊme API : registerCallback($path, callable), parse($stream).
 * Les callbacks reçoivent (StreamParser $parser, \SimpleXMLElement $node).
 */
class StreamParser
{
    /** @var array<string, callable[]> */
    private array $callbacks = [];

    private bool $stopped = false;

    public function registerCallback(string $path, callable $callback): self
    {
        $this->callbacks[rtrim($path, '/')][] = $callback;

        return $this;
    }

    public function stop(): void
    {
        $this->stopped = true;
    }

    /**
     * @param resource|string $source flux (readStream) ou chaÃŪne XML
     */
    public function parse($source): void
    {
        $this->stopped = false;

        $xml = is_resource($source) ? stream_get_contents($source) : (string) $source;

        $reader = new \XMLReader();
        if (!$reader->XML($xml, null, LIBXML_NOCDATA | LIBXML_NONET)) {
            throw new \RuntimeException('XML invalide ou illisible.');
        }

        $stack = [];

        try {
            while (!$this->stopped && $reader->read()) {
                if (\XMLReader::ELEMENT === $reader->nodeType) {
                    $stack[] = $reader->name;
                    $path = '/'.implode('/', $stack);

                    if (isset($this->callbacks[$path])) {
                        $node = simplexml_load_string($reader->readOuterXml());

                        if (false !== $node) {
                            foreach ($this->callbacks[$path] as $callback) {
                                $callback($this, $node);
                            }
                        }

                        // sous-arbre dÃĐjÃ  consommÃĐ : on le saute et on dÃĐpile
                        $reader->next();
                        array_pop($stack);

                        // next() a pu nous placer sur un autre ÃĐlÃĐment : on le retraite
                        if (\XMLReader::ELEMENT === $reader->nodeType) {
                            $stack[] = $reader->name;
                            // (cas rare : frÃĻre immÃĐdiat, voir note ci-dessous)
                        }
                        continue;
                    }

                    if ($reader->isEmptyElement) {
                        array_pop($stack);
                    }
                } elseif (\XMLReader::END_ELEMENT === $reader->nodeType) {
                    array_pop($stack);
                }
            }
        } finally {
            $reader->close();
        }
    }
}
