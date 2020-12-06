<?= "<?php\n" ?>

namespace <?= $namespace ?>;

use <?= $entity_full_class_name ?>;
use <?= $form_full_class_name ?>;
<?php if (isset($repository_full_class_name)): ?>
use <?= $repository_full_class_name ?>;
<?php endif ?>
use FOS\RestBundle\Controller\<?= $parent_class_name ?>;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class <?= $class_name ?> extends <?= $parent_class_name; ?><?= "\n" ?>
{
    /**
     * @Route("<?= $route_path ?>/", name="<?= $route_name ?>_index", methods={"GET"})
     */
<?php if (isset($repository_full_class_name)): ?>
    public function index(<?= $repository_class_name ?> $<?= $repository_var ?>, $embedType = false): Response
    {
       
       
        $templateBase = '<?= $templates_path ?>/';
        $template = 'index.html.twig';
        switch ($embedType) {
            case 'groupListContainer':
                $template = 'list_group.html.twig';
                break;
            case 'dropdownList':
                $template = 'dropdown.html.twig';
                break;
            case false:
                break;
            default:
                return $this->render('embedTypeNotFound.html.twig', [
                    'embedType' => $embedType,
                    'method' => __METHOD__,
                    'class' => __CLASS__,
                ]);
        }
       
        return $this->render($templateBase.$template, [
            '<?= $entity_twig_var_plural ?>' => $<?= $repository_var ?>->findAll(),
        ]);
    }
<?php else: ?>
    public function index(): Response
    {
        $<?= $entity_var_plural ?> = $this->getDoctrine()
            ->getRepository(<?= $entity_class_name ?>::class)
            ->findAll();

        return $this->render('<?= $templates_path ?>/index.html.twig', [
            '<?= $entity_twig_var_plural ?>' => $<?= $entity_var_plural ?>,
        ]);
    }
<?php endif ?>

    /**
     * @Route("/api<?= $route_path ?>/", name="api_<?= $route_name ?>_index", methods={"GET"})
     */
<?php if (isset($repository_full_class_name)): ?>
    public function apiIndex(<?= $repository_class_name ?> $<?= $repository_var ?>): Response
    {
        
        $view = $this->view($<?= $repository_var ?>->findAll(), 200);

        return $this->handleView($view);
    }
<?php endif ?>



    /**
     * @Route("<?= $route_path ?>/new", name="<?= $route_name ?>_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $<?= $entity_var_singular ?> = new <?= $entity_class_name ?>();
        $form = $this->createForm(<?= $form_class_name ?>::class, $<?= $entity_var_singular ?>);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($<?= $entity_var_singular ?>);
            $entityManager->flush();

            return $this->redirectToRoute('<?= $route_name ?>_index');
        }

        return $this->render('<?= $templates_path ?>/new.html.twig', [
            '<?= $entity_twig_var_singular ?>' => $<?= $entity_var_singular ?>,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("<?= $route_path ?>/{<?= $entity_identifier ?>}", name="<?= $route_name ?>_show", methods={"GET"})
     */
    public function show(<?= $entity_class_name ?> $<?= $entity_var_singular ?>): Response
    {
        return $this->render('<?= $templates_path ?>/show.html.twig', [
            '<?= $entity_twig_var_singular ?>' => $<?= $entity_var_singular ?>,
        ]);
    }


    /**
     * @Route("/api<?= $route_path ?>/{<?= $entity_identifier ?>}", name="api_<?= $route_name ?>_show", methods={"GET"})
     */
    public function apiShow(<?= $entity_class_name ?> $<?= $entity_var_singular ?>): Response
    {
        
        $view = $this->view($<?= $entity_var_singular ?>, 200);

        return $this->handleView($view);
    }

    /**
     * @Route("<?= $route_path ?>/{<?= $entity_identifier ?>}/edit", name="<?= $route_name ?>_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, <?= $entity_class_name ?> $<?= $entity_var_singular ?>): Response
    {
        $form = $this->createForm(<?= $form_class_name ?>::class, $<?= $entity_var_singular ?>);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('<?= $route_name ?>_index');
        }

        return $this->render('<?= $templates_path ?>/edit.html.twig', [
            '<?= $entity_twig_var_singular ?>' => $<?= $entity_var_singular ?>,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("<?= $route_path ?>/{<?= $entity_identifier ?>}", name="<?= $route_name ?>_delete", methods={"DELETE"})
     */
    public function delete(Request $request, <?= $entity_class_name ?> $<?= $entity_var_singular ?>): Response
    {
        if ($this->isCsrfTokenValid('delete'.$<?= $entity_var_singular ?>->get<?= ucfirst($entity_identifier) ?>(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($<?= $entity_var_singular ?>);
            $entityManager->flush();
        }

        return $this->redirectToRoute('<?= $route_name ?>_index');
    }
}
