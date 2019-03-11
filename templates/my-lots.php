<main>
    <nav class="nav">
        <?= $navigation ;?>
    </nav>
    <section class="rates container">
        <h2>Мои ставки</h2>
        <table class="rates__list">
            <?php foreach ($lots as $lot) :?>
            <tr class="rates__item <?= $lot['rate_state'] ;?>">
                <td class="rates__info">
                    <div class="rates__img">
                        <img src="<?=$lot['image'];?>" width="54" height="40" alt="<?=$lot['title'];?>">
                    </div>
                    <div>
                        <h3 class="rates__title"><a href="<?=$lot['link'];?>"><?=$lot['title'];?></a></h3>
                    <?php if ($lot['rate_state'] === 'rates__item--win') :?>
                        <p><?= $lot['contacts'] ;?></p>
                    <?php endif ;?>
                    </div>
                </td>
                <td class="rates__category">
                    <?=$lot['category'];?>
                </td>
                <td class="rates__timer">
                    <?php if ($lot['timer'] === 'timer--end') :?>
                        <div class="timer timer--end">Торги окончены</div>
                    <?php elseif ($lot['timer'] === 'timer--win') :?>
                        <div class="timer timer--win">Ставка выиграла</div>
                    <?php elseif (strtotime($lot['date_finish']) < strtotime('+24 hours now')) :?>
                        <div class="timer timer--finishing"><?=time_rest($lot['date_finish']);?></div>
                    <?php else :?>
                        <div class="timer"><?=time_rest($lot['date_finish']);?></div>
                    <?php endif ;?>
                </td>
                <td class="rates__price">
                    <?=number_format($lot['my_rate'], 0, '.', ' ');?> р
                </td>
                <td class="rates__time">
                    <?=date_format(date_create($lot['date_add']),
                        'd.m.y' . ' в ' . 'H:i');?>
                </td>
            </tr>
            <?php endforeach ;?>
        </table>
    </section>
</main>