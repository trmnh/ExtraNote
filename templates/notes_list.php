<!-- templates/notes_list.php -->
<div class="row">
    <div class="col-12">
        <h1 class="mb-3 appMainColor appPageTitle">Notes <img src="assets/img/section.png"></h1>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <form id="form_sort_note" method="post">
            <label for="sort_note" class="label_sort_note">Trier par</label>
            <select name="sort_note" id="sort_note" class="select_sort_note">
                <option value="date" <?php echo ($sorted_by == "date" ? "selected" : ""); ?>>Date</option>
                <option value="title" <?php echo ($sorted_by == "title" ? "selected" : ""); ?>>Titre</option>
                <option value="type" <?php echo ($sorted_by == "type" ? "selected" : ""); ?>>Type</option>
                <option value="favoris" <?php echo ($sorted_by == "favoris" ? "selected" : ""); ?>>Favoris</option>
            </select>
            <select name="sort_order" id="sort_order" class="select_sort_order">
                <option value="asc" <?php echo ($sort_order == "asc" ? "selected" : ""); ?>>Asc</option>
                <option value="desc" <?php echo ($sort_order == "desc" ? "selected" : ""); ?>>Desc</option>
            </select>
            <button type="submit" class="btn btn-outline-success">Trier</button>
        </form>
    </div>
    <div class="col-md-9">
        <div class="input_wrapper float-end">
            <form id="form_search_note" method="post">
                <input type="hidden" name="action" value="search">
                <input type="text" name="search_term" id="search_term" class="input_search_note" placeholder="Rechercher une note">
                <button type="submit" class="btn_submit_search" title="Soumettre la recherche">&rarr;</button>
            </form>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <?php foreach ($notes as $note): ?>
            <a href="index.php?page=view&file=<?php echo htmlspecialchars($note['filename']); ?>" class="appNoteBox">
                <div class="row tuileNote" alt="Lire">
                    <div class="col-12">
                        <?php if ($note['favoris']): ?>
                            <img src="assets/img/favorite.png" alt="favoris">
                        <?php endif; ?>
                        <span class="badge text-bg-secondary"><?php echo htmlspecialchars($note['type']); ?></span>
                        <h2 class="mb-3 appMainColor"><?php echo htmlspecialchars($note['title']); ?></h2>
                        <small><?php echo htmlspecialchars($note['date']); ?></small>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>
