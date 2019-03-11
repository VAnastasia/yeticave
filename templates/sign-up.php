<main>
	<nav class="nav">
        <?= $navigation ;?>
	</nav>
	<form class="form container <?=(!empty($errors) ? "form--invalid" : "");?>" action="sign-up.php" method="post" enctype="multipart/form-data">
		<h2>Регистрация нового аккаунта</h2>
		<div class="form__item <?=($errors['email'] ? "form__item--invalid" : "");?>">
			<label for="email">E-mail*</label>
			<input id="email" type="email" name="email" placeholder="Введите e-mail" value="<?=($form['email'] ?? "");?>">
			<span class="form__error"><?=($errors['email'] ?? "");?></span>
		</div>
		<div class="form__item <?=($errors['password'] ? "form__item--invalid" : "");?>">
			<label for="password">Пароль*</label>
			<input id="password" type="password" name="password" placeholder="Введите пароль" value="<?=($form['password'] ?? "");?>">
			<span class="form__error"><?=($errors['password'] ?? "");?></span>
		</div>
		<div class="form__item <?=($errors['name'] ? "form__item--invalid" : "");?>">
			<label for="name">Имя*</label>
			<input id="name" type="text" name="name" placeholder="Введите имя" value="<?=($form['name'] ?? "");?>">
			<span class="form__error"><?=($errors['name'] ?? "");?></span>
		</div>
		<div class="form__item <?=($errors['message'] ? "form__item--invalid" : "");?>">
			<label for="message">Контактные данные*</label>
			<textarea id="message" name="message" placeholder="Напишите как с вами связаться" ><?=($form['message'] ?? "");?></textarea>
			<span class="form__error"><?=($errors['message'] ?? "");?></span>
		</div>
		<div class="form__item form__item--file form__item--last">
			<label>Аватар</label>
			<div class="preview">
				<button class="preview__remove" type="button">x</button>
				<div class="preview__img">
					<img src="<?=$form['file'];?>" width="113" height="113" alt="Ваш аватар">
				</div>
			</div>
			<div class="form__input-file">
				<input class="visually-hidden" name="file" type="file" id="photo2" value="">
				<label for="photo2">
					<span>+ Добавить</span>
				</label>
			</div>
		</div>
		<span class="form__error form__error--bottom"><?=(empty($errors) ? "" : "Пожалуйста, исправьте ошибки в форме.");?></span>
		<button type="submit" class="button">Зарегистрироваться</button>
		<a class="text-link" href="login.php">Уже есть аккаунт</a>
	</form>
</main>