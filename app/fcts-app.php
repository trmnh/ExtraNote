<?php
/**
 * ******************************************************************
 *  Fonctions de base de  l'application
 * ******************************************************************
 */

/**
 * Retourne toutes les notes sous la forme d'un tableau de tableaux
 * 
 * Recherche les fichiers "*.json" dans le répertoire des notes passé en paramètre
 * ouvre les contenus de chaque note et les fusionne dans un tableau
 * 
 * @param string $directory 
 * @return array|empty
 */
function GETListAllNotes($directory = NOTES_DIR) {
    $files = glob($directory.'/*.json');    
    $notes = [];

    if(file_exists($directory))
    {
        foreach($files as $file){
            $notes = array_merge($notes, json_decode(file_get_contents($file), true));
        }
    }

    return $notes;
}
/**
 * Système de tri des notes
 * Retourne un tableau de notes triées en fonction des paramètres
 * 
 * @param mixed $listNotes 
 * @param string $term 
 * @param string $order 
 * @return array 
 */
function GETNotesSortedBy($listNotes, $term = SORT_BY_DEFAULT, $order = SORT_ORDER_DEFAULT) {
    // Systeme de tri
    switch($term) {
        case SORT_BY_DATE:
            if ($order == SORT_ORDER_DESC) {
                usort($listNotes, function($a, $b) use ($term) {
                    $dateA = isset($a[$term]) ? strtotime($a[$term]) : 0;
                    $dateB = isset($b[$term]) ? strtotime($b[$term]) : 0;
                    return $dateB - $dateA;
                });
            } else {
                usort($listNotes, function($a, $b) use ($term) {
                    $dateA = isset($a[$term]) ? strtotime($a[$term]) : 0;
                    $dateB = isset($b[$term]) ? strtotime($b[$term]) : 0;
                    return $dateA - $dateB;
                });
            }
            break;
        case SORT_BY_TITLE:
            if ($order == SORT_ORDER_DESC) {
                usort($listNotes, function($a, $b) {
                    $titleA = isset($a['title']) ? $a['title'] : '';
                    $titleB = isset($b['title']) ? $b['title'] : '';
                    return strcmp($titleB, $titleA);
                });
            } else {
                usort($listNotes, function($a, $b) {
                    $titleA = isset($a['title']) ? $a['title'] : '';
                    $titleB = isset($b['title']) ? $b['title'] : '';
                    return strcmp($titleA, $titleB);
                });
            }
            break;
        case SORT_BY_TYPE:
            if ($order == SORT_ORDER_DESC) {
                usort($listNotes, function($a, $b) {
                    $typeA = isset($a['type']) ? $a['type'] : '';
                    $typeB = isset($b['type']) ? $b['type'] : '';
                    return strcmp($typeB, $typeA);
                });
            } else {
                usort($listNotes, function($a, $b) {
                    $typeA = isset($a['type']) ? $a['type'] : '';
                    $typeB = isset($b['type']) ? $b['type'] : '';
                    return strcmp($typeA, $typeB);
                });
            }
            break;
        case SORT_BY_FAVORIS:
            $listNotes = array_filter($listNotes, function($note) {
                return isset($note['favoris']) && $note['favoris'] == 1;
            });
            break;
    }

    return $listNotes;
}



/**
 * Ajout d'une nouvelle note dans un fichier au format JSON
 * 
 * @param mixed $title 
 * @param mixed $content 
 * @param mixed $type 
 * @param mixed $favoris 
 * @return int|false 
 */

 function ADDNewNoteToFile($title, $content, $type, $favoris) {
    $filename = NOTES_DIR . '/notes-' . date("d-m-Y") . '-' . T_RandNumber(5) . '.json';

    $note = [
        'title' => $title,
        'content' => $content,
        'type' => $type,
        'favoris' => $favoris,
        'filename' => $filename,
        'date' => date("d-m-Y H:i:s")
    ];      

    // Charger les notes existantes si le fichier existe, sinon créer un nouveau tableau
    $notes = [];
    if (file_exists($filename)) {
        $notes = json_decode(file_get_contents($filename), true);
    }

    // Ajouter la nouvelle note
    $notes[] = $note;

    // Enregistrer les notes dans le fichier JSON
    if (file_put_contents($filename, json_encode($notes, JSON_PRETTY_PRINT)) === false) {
        return false;
    }

    return true;
}




/**
 * Supprimer une note = suppression du fichier
 * 
 * @param mixed $file 
 * @return bool 
 */
function DELETENoteFile($file) {
    if(file_exists($file))
        $st = unlink($file);
    else
        $st = false;

    return $st;
}

/**
 * Charger le contenu d'une note au départ du fichier passé en paramètre
 * 
 * @param mixed $file 
 * @return array|false 
 */
function LOADNoteFromFile($file) {    
    // Si le fichier n'existe pas
    if(!file_exists($file))
        return false;

    // Chargement de la note
    $note = json_decode(file_get_contents($file), true);
    $note = $note[0];

    return $note;
}

/**
 * Mise à jour du contenu d'une note dans le fichier
 * 
 * @param mixed $note_record 
 * @return int|false 
 */
function UPDATENoteFile($note_record) {
    $result = false;
    $note [] = [
        'title' => $note_record['title'],
        'content' => $note_record['content'],
        'type' => $note_record['type'],
        'favoris' => $note_record['favoris'],
        'filename' => $note_record['file'],
        'date' => $note_record['date']
    ];

    $result = file_put_contents($note_record['file'], json_encode($note));
    
    return $result;
}


/**
 * Recherche une chaîne de caractères dans le titre ou le contenu des notes
 * Retourne un tableau de notes correspondant à la recherche
 * 
 * @param mixed $listNotes 
 * @param mixed $search 
 * @return array|false 
 */
function SEARCHInNotes($listNotes, $search) {
    $search = strtolower($search);
    $listNotes = array_filter($listNotes, function($note) use ($search){
        return (strpos(strtolower($note['title']), $search) !== false || strpos(strtolower($note['content']), $search) !== false);
    });

    return $listNotes;
}

/**
 * Gestion des valeurs de tri pour l'affichage des liste déroulantes
 * du formulaire de tri des notes 
 * Utilisée dans la fonction d'affichage du formulaire de tri : HTMLInsertFormSortNote()
 * 
 * @param string $sorted_by 
 * @param string $sort_order 
 * @return string[] 
 */
function SORTManager($sorted_by, $sort_order) {

    // Gestion du selected du selected_order 
    $selected = [SORT_BY_DATE => '', SORT_BY_TITLE => '', SORT_BY_TYPE => '', SORT_BY_FAVORIS => ''];

    switch ($sorted_by) {
        case SORT_BY_DATE:
            $selected[SORT_BY_DATE] = 'selected';
            break;
        case SORT_BY_TITLE:  
            $selected[SORT_BY_TITLE] = 'selected'; 
            break;
        case SORT_BY_TYPE:
            $selected[SORT_BY_TYPE] = 'selected';
            break;
        case SORT_BY_FAVORIS:
            $selected[SORT_BY_FAVORIS] = 'selected';
            break;        
    }

    // Gestions des options de tri
    $selected_order = [SORT_ORDER_ASC => '', SORT_ORDER_DESC => ''];

    switch ($sort_order) {
        case SORT_ORDER_ASC:
            $selected_order[SORT_ORDER_ASC] = 'selected';
            break;
        case SORT_ORDER_DESC:  
            $selected_order[SORT_ORDER_DESC] = 'selected'; 
            break;        
    }

    return array('selected' => $selected, 'selected_order' => $selected_order);

}

