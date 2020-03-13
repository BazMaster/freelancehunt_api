<?php /*** if($content['count']): ?>
	<small class="text-muted">Задач: <?= $content['count'] ?></small>


	<?php if($content['count'] > $content['perPage']): ?>
		<nav aria-label="Page navigation example">
			<ul class="pagination justify-content-center" data-page="<?=$content['page']?>">
				<li class="page-item<?php if($content['page'] == 1): ?> disabled<?php endif; ?>">
					<a class="page-link" href="/get/<?=$content['prev']?>">
						Назад
					</a>
				</li>
				<li class="page-item<?php if($content['page'] >= $content['pages']): ?> disabled<?php endif; ?>">
					<a class="page-link" href="/get/<?=$content['next']?>">Вперёд</a>
				</li>
			</ul>
		</nav>
	<?php endif; ?>

<?php else: ?>
	<div class="alert alert-secondary mt-3">Записей не найдено</div>
<?php endif; **/ ?>
