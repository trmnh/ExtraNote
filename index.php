<?php
// *******************************************************
// --                    CONTROLLER                     --
// *******************************************************
require 'conf.php';
require 'app/fcts-tools.php';
require 'app/fcts-html.php';
require 'app/fcts-app.php';

//T_Printr($_POST, 'POST');
//T_Printr($_GET, 'GET');   

// Initialisation des variables
$section_message = ''; // Initialisation de la section des messages
$section_notes = ''; // Initialisation de la section des notes
$section_favoris = ''; // Initialisation de la section des favoris

// Tri des notes
$sorted_by = isset($_POST['sort_note']) ? $_POST['sort_note'] : 'date';
$sort_order = isset($_POST['sort_order']) ? $_POST['sort_order'] : 'desc';


$notes = GETListAllNotes();
$notes = GETNotesSortedBy($notes, $sorted_by, $sort_order);

session_start();

$messages = getMessages();
foreach ($messages as $msg) {
    echo '<div class="alert alert-' . htmlspecialchars($msg['type']) . '">' . htmlspecialchars($msg['message']) . '</div>';
}

//$action = $_GET['page'] ?? 'home';

// Gestion de l'affichage des pages et de leur contenu
$action = isset($_GET['page']) ? $_GET['page'] : '';

// Si une action a été effectuée avec succès, définir le message de succès correspondant
if (isset($_GET['success'])) {
    switch ($_GET['success']) {
        case 'add_note':
            $section_message = '<div class="alert alert-success alert-dismissible fade show auto-dismiss" role="alert">Note ajoutée avec succès !</div>';
            break;
        case 'edit_note':
            $section_message = '<div class="alert alert-success alert-dismissible fade show auto-dismiss" role="alert">La note a été modifiée avec succès.</div>';
            break;
        case 'delete_note':
            $section_message = '<div class="alert alert-success alert-dismissible fade show auto-dismiss" role="alert">La note a été supprimée avec succès.</div>';
            break;
    }
}


switch ($action) {
    case 'view':
        // Afficher les détails d'une note
        if (isset($_GET['file'])) {
            $file = $_GET['file'];
            // Charger les détails de la note à partir du fichier
            $note_details = LOADNoteFromFile($file);
            if ($note_details) {
                // Afficher les détails de la note
                ob_start();
                include 'templates/view_note.php';
                $section_notes = ob_get_clean();
            } else {
                // Afficher un message d'erreur si la note n'existe pas
                $error = "La note que vous essayez de visualiser n'existe pas.";
            }
        } else {
            // Afficher un message d'erreur si le fichier de la note n'est pas spécifié
            $error = "Fichier de note manquant.";
        }
        break;


case 'addnote':
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title_note'] ?? '';
        $content = $_POST['content_note'] ?? '';
        $type = $_POST['type_note'] ?? '';
        $favoris = isset($_POST['favori_note']) ? 1 : 0;

        $result = ADDNewNoteToFile($title, $content, $type, $favoris);
        if ($result) {
            // Note ajoutée avec succès, rediriger l'utilisateur
            header("Location: index.php?success=add_note");
            exit;
        } else {
            // Une erreur s'est produite lors de l'ajout de la note
            header("Location: index.php?error=add_note");
            exit;
        }
    } else {
        // Si la méthode de requête n'est pas POST, afficher le formulaire d'ajout de note
        ob_start();
        include 'templates/add_note_form.php';
        $section_notes = ob_get_clean();
    }
    break;


        
        
    

    case 'edit_note':
        // Récupérer l'identifiant de la note à éditer depuis l'URL
        $note_id = $_GET['file'] ?? '';
    
        if (empty($note_id)) {
            addMessage('Aucun identifiant de note spécifié.', 'error');
            header("Location: index.php");
            exit();
        }
    
        // Récupérer les détails de la note à éditer
        $note = LOADNoteFromFile($note_id);
    
        // Debug : Vérifier que la note a bien été chargée
        if ($note === false) {
            addMessage('La note spécifiée est introuvable.', 'error');
            header("Location: index.php");
            exit();
        }
    
        // Traitement du formulaire d'édition
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer l'identifiant de la note depuis les données POST
            $note_id = $_POST['note_id'] ?? '';
    
            if (empty($note_id)) {
                addMessage('Aucun identifiant de note spécifié.', 'error');
            } else {
                $title = $_POST['title'] ?? '';
                $content = $_POST['content'] ?? '';
                $type = $_POST['type'] ?? 'note';
                $favoris = isset($_POST['favoris']) ? 1 : 0;
    
                // Mettre à jour la note
                $result = UPDATENoteFile([
                    'title' => $title,
                    'content' => $content,
                    'type' => $type,
                    'favoris' => $favoris,
                    'file' => $note_id,
                    'date' => date("d-m-Y H:i:s")
                ]);
    
                if ($result) {
                    addMessage('Note mise à jour avec succès.', 'success');
                    // Rediriger vers la page principale après la mise à jour
                    header("Location: index.php");
                    exit();
                } else {
                    addMessage('Erreur lors de la mise à jour de la note.', 'error');
                }
            }
        } else {
            // Afficher le formulaire de modification de note avec les détails pré-remplis
            ob_start();
            include 'templates/edit_note_form.php';
            $section_notes = ob_get_clean();
        }
        break;
    
    
    
    
    
        case 'confirm_delete':
            if (isset($_GET['file'])) {
                $file = NOTES_DIR . basename($_GET['file']);
                if (file_exists($file)) {
                    $note_details = LOADNoteFromFile($file);
                    $note_name = $note_details['title'];
                    ob_start();
                    include 'templates/delete_note_confirmation.php';
                    $section_notes = ob_get_clean();
                } else {
                    $error = "La note que vous essayez de supprimer n'existe pas.";
                }
            } else {
                $error = "Fichier de note manquant pour la suppression.";
            }
            break;
        
        case 'delete_note':
            if (isset($_GET['file'])) {
                $file = NOTES_DIR . basename($_GET['file']);
                if (file_exists($file)) {
                    if (DELETENoteFile($file)) {
                        addMessage('Note supprimée avec succès.', 'success');
                    } else {
                        addMessage('Erreur lors de la suppression de la note.', 'error');
                    }
                } else {
                    addMessage('La note que vous essayez de supprimer n\'existe pas.', 'error');
                }
            } else {
                addMessage('Fichier de note manquant pour la suppression.', 'error');
            }
            header("Location: index.php");
            exit();
            break; 

            case 'search_notes':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Traiter le formulaire de recherche de notes
                    $search_term = $_POST['search_term'];
                    addMessage('Chaîne recherchée : "' . htmlspecialchars($search_term) . '"', 'info');
            
                    // Appeler la fonction pour rechercher dans les notes
                    $search_results = SEARCHInNotes($notes, $search_term);
            
                    // Afficher les résultats de la recherche
                    ob_start();
                    if (!empty($search_results)) {
                        foreach ($search_results as $note) {
                            echo '<a href="index.php?page=view&file=' . htmlspecialchars($note['filename']) . '" class="appNoteBox">
                                    <div class="row tuileNote" alt="Lire">
                                        <div class="col-12">';
                            if ($note['favoris']) {
                                echo '<img src="assets/img/favorite.png" alt="favoris">';
                            }
                            echo '<span class="badge text-bg-secondary">' . htmlspecialchars($note['type']) . '</span>
                                  <h2 class="mb-3 appMainColor">' . htmlspecialchars($note['title']) . '</h2>
                                  <small>' . htmlspecialchars($note['date']) . '</small>
                                  </div>
                                  </div></a>';
                        }
                    } else {
                        echo '<div>
                                <p>Aucun résultat trouvé pour "' . htmlspecialchars($search_term) . '".</p>
                              </div>';
                    }
                    echo '<p>
                            <a href="index.php" class="btn btn-outline-success btn-sm">RESET ⭯</a>
                          </p>';
                    
                    $section_notes = ob_get_clean();
                }
                break;
                
    default:

        
        // Affichage par défaut (peut être la page d'accueil)
        $section_notes = ''; // Initialisation de la section des notes

        // Ajout de la section HTML au début de la section des notes
        $section_notes .= '
        <div class="row">
            <div class="col-12">
                <h1 class="mb-3 appMainColor appPageTitle">Notes <img src="assets/img/section.png"></h1>
            </div>
        </div>
        ';

        $section_notes .= '
        <div class="row">
            <div class="col-md-3">
                <form id="form_sort_note" method="post">
                    <label for="sort_note" class="label_sort_note">Trier par</label>
                    <select name="sort_note" id="sort_note" class="select_sort_note">
                        <option value="date" ' . ($sorted_by == "date" ? "selected" : "") . '>Date</option>
                        <option value="title" ' . ($sorted_by == "title" ? "selected" : "") . '>Titre</option>
                        <option value="type" ' . ($sorted_by == "type" ? "selected" : "") . '>Type</option>
                        <option value="favoris" ' . ($sorted_by == "favoris" ? "selected" : "") . '>Favoris</option>
                    </select>
                    <select name="sort_order" id="sort_order" class="select_sort_order">
                        <option value="asc" ' . ($sort_order == "asc" ? "selected" : "") . '>Asc</option>
                        <option value="desc" ' . ($sort_order == "desc" ? "selected" : "") . '>Desc</option>
                    </select>
                    <!--<button type="submit" class="btn btn-outline-success">Trier</button>-->
                </form>
            </div>
        
            <div class="col-md-9">
                <div class="input_wrapper float-end">
                    <form id="form_search_note" method="post" action="index.php?page=search_notes">
                        <input type="text" name="search_term" id="search_term" class="input_search_note" placeholder="Rechercher une note">
                        <button type="submit" class="btn_submit_search" title="Soumettre la recherche">&rarr;</button>
                    </form>
                </div>
            </div>
        </div>';
        ;




        $section_notes .= '
        <div class="row">
            <div class="col-12">';

        foreach ($notes as $note) {
            $section_notes .= '
            <a href="index.php?page=view&file=' . $note['filename'] . '" class="appNoteBox">
                <div class="row tuileNote" alt="Lire">
                    <div class="col-12">';

            if ($note['favoris']) {
                $section_notes .= '
                <img src="assets/img/favorite.png" alt="favoris">';
            }

            $section_notes .= '
                <span class="badge text-bg-secondary">' . $note['type'] . '</span>
                <h2 class="mb-3 appMainColor">' . $note['title'] . '</h2>
                <small>' . $note['date'] . '</small>
                </div>
            </div></a>';
        }

        $section_notes .= '
        </div>
        </div>';

        // Affichage section favoris
        $section_favoris = ''; // Initialisation de la section des favoris

        // Ajout de la section HTML pour les favoris
        $section_favoris .= '<hr>
        <div class="row">
            <div class="col-12">
                <h1 class="mb-3 appMainColor appPageTitle">Favoris <img src="assets/img/section.png"></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div>';

        // Parcours des notes et ajout des favoris
        foreach ($notes as $note) {
            if ($note['favoris']) {
                $section_favoris .= '
                <a href="index.php?page=view&file=' . $note['filename'] . '" class="appNoteBox">
                    <div class="row tuileNote-mini" alt="Lire">
                        <div class="col-12">
                            <span class="badge text-bg-secondary">' . $note['type'] . '</span>
                            <p class="mb-3 appMainColor">' . $note['title'] . '</p>
                        </div>
                    </div>
                </a>';
            }
        }

        $section_favoris .= '
                </div>
            </div>
        </div>';
        break;
}



?>

<!DOCTYPE html>
<html lang="fr">
    <?php echo HTMLInsertHeader(); ?>
    <body>
        <div class="container">
            <!-- Banner -->
            <?php echo HTMLInsertBanner(); ?>
            <!-- Menu -->
            <?php echo HTMLInsertMenu(); ?>
            <hr>

            <!-- Affichage des messages -->
            <?php echo $section_message; ?>

            <!-- Affichage des notes -->
            <?php echo $section_notes; ?>

            <!-- Affichage des favoris -->
            <?php echo $section_favoris; ?>
        </div><!-- container -->

        <!-- Footer -->
        <?php echo HTMLInsertFooter(); ?>

        <!-- Scripts -->
        <script src="assets/js/app.js"></script>
        <script src="assets/js/tooltip.js"></script>
    </body>
</html>