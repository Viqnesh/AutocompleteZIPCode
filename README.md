# AutocompleteZIPCode
Système d'autocompletion des Villes de France à partir des codes postales pour les adresses (WooCommerce)

<h3>Etape 1 :</h3> 

Ajouter dans le fichier functions.php les lignes suivantes :

function my_custom_scripts() {
    wp_enqueue_script( 'custom-js', get_stylesheet_directory_uri() . '/js/custom.js', array( 'jquery' , 'jquery-ui-autocomplete' ),'1.1',true );
    wp_localize_script( 'custom-js', 'ajaxscript', array( 'templatedir' => get_stylesheet_directory_uri().'/js/data.json' ) );

}
add_action( 'wp_enqueue_scripts', 'my_custom_scripts' );

Explication :

1ere ligne : ajout du fichier custom.js , autoriser JQuery et Jquery UI Autocomplete
2eme ligne : !Important! Passer une variable PHP à une variable JS. Içi c'est le chemin qui mène au fichier data.json qui contient nos villes et codes postales. 

<h3>Etape 2 (Optionnel) :</h3>

Mettre le champ Ville en readonly pour que l'utilisateur ne puisse pas le modifier. De cette manière là, le seul moyen de changer la ville, c'est en saisissant un code postal différent.

$fields['billing']['billing_city']['custom_attributes'] = array('readonly'=>'readonly');
