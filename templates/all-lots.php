<main>
    <nav class="nav">
        <?= $navigation ;?>
    </nav>
    <div class="container">
        <section class="lots">
            <h2>Все лоты в категории <span>«<?= $categories_array[0]['name'] ;?>»</span></h2>
            <ul class="lots__list">
                <?php foreach($lots_array as $key => $value):?>
                    <?php if (strtotime($value['date_finish']) > strtotime("today")) : ?>
                        <li class="lots__item lot">
                            <div class="lot__image">
                                <img src="<?=$value['image'];?>" width="350" height="260" alt="<?=$value['title'];?>">
                            </div>
                            <div class="lot__info">
                                <span class="lot__category"><?=$value['name'];?></span>
                                <h3 class="lot__title"><a class="text-link" href="lot.php?lot_id=<?=$value['id'];?>"><?=$value['title'];?></a></h3>
                                <div class="lot__state">
                                    <div class="lot__rate">
                                        <span class="lot__amount">Стартовая цена</span>
                                        <span class="lot__cost"><?=price_format($value['start_price']); ?></span>
                                    </div>
                                    <div class="lot__timer timer <?=(strtotime($value['date_finish']) < strtotime("+24 hours now")) ? "timer--finishing" : "" ;?>">
                                        <?=time_rest($value['date_finish']);?>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </section>
        <ul class="pagination-list">
            <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
            <li class="pagination-item pagination-item-active"><a>1</a></li>
            <li class="pagination-item"><a href="#">2</a></li>
            <li class="pagination-item"><a href="#">3</a></li>
            <li class="pagination-item"><a href="#">4</a></li>
            <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
        </ul>
    </div>
</main>