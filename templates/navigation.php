<ul class="nav__list container">
    <?php foreach ($categories_array as $key => $value): ?>
        <li class="nav__item <?= (isset($_GET['category_id']) && $_GET['category_id'] == $value['id'] ? "nav__item--current" : "") ;?>">
            <a href="all-lots.php?category_id=<?=$value['id'];?>"><?=$value['name']; ?></a>
        </li>
    <?php endforeach; ?>
</ul>