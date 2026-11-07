/*
 * app.js
 */

// Import de votre CSS personnalisé EN PREMIER, ou juste après le thème
// pour s'assurer que vos surcharges (app.css) prennent le dessus sur Superhero.
import './theme/superhero/bootstrap.css';
import './styles/app.css';

import $ from 'jquery';
global.$ = global.jQuery = $;

require('bootstrap');
require('jq-timeline');