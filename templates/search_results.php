<?php if (!empty($search_results)): ?>
    <div class="search-results">
        <h2>Résultats de la recherche :</h2>
        <?php foreach ($search_results as $note): ?>
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
<?php else: ?>
    <div class="no-results">
        <p>Aucun résultat trouvé pour "<?php echo htmlspecialchars($search_term); ?>".</p>
    </div>
<?php endif; ?>
