<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
?>
<div class="nt-container px-0 px-sm-4 px-xl-0 pt-0 pt-sm-4">
<div class="pb-4 px-3 px-sm-0 font-weight-normal">
	<div class="row na-row">
		<!-- 메인 영역 -->
		<div class="col na-col">

			<div class="mb-3 mb-sm-4">
				<?php echo na_widget('data-carousel', 'title-2', 'xl=27%', 'auto=0'); //타이틀 ?>
			</div>

			<!-- 위젯 시작 { -->
			<h3 class="h3 f-lg en">
				<a href="<?php echo get_pretty_url('video'); ?>">
					<span class="float-right more-plus"></span>
					게임
				</a>
			</h3>
			<hr class="hr"/>
			<div class="px-3 px-sm-0 mt-3 mb-4">
				<?php echo na_widget('data-slider', 'game-1'); ?>
			</div>
			<!-- } 위젯 끝-->

			<!-- 위젯 시작 { -->
			<h3 class="h3 f-lg en">
				<a href="<?php echo get_pretty_url('video'); ?>">
					<span class="float-right more-plus"></span>
					배너
				</a>
			</h3>
			<hr class="hr"/>
			<div class="px-3 px-sm-0 mt-3 mb-4">
				<?php echo na_widget('data-slider', 'game-2'); ?>
			</div>
			<!-- } 위젯 끝-->

			<!-- 위젯 시작 { -->
			<h3 class="h3 f-lg en">
				<a href="<?php echo get_pretty_url('video'); ?>">
					<span class="float-right more-plus"></span>
					배너
				</a>
			</h3>
			<hr class="hr"/>
			<div class="px-3 px-sm-0 mt-3 mb-4">
				<?php echo na_widget('data-slider', 'game-3'); ?>
			</div>
			<!-- } 위젯 끝-->

			<!-- 위젯 시작 { -->
			<h3 class="h3 f-lg en">
				<a href="<?php echo get_pretty_url('video'); ?>">
					<span class="float-right more-plus"></span>
					배너
				</a>
			</h3>
			<hr class="hr"/>
			<div class="px-3 px-sm-0 mt-3 mb-4">
				<?php echo na_widget('data-slider', 'game-4'); ?>
			</div>
			<!-- } 위젯 끝-->

			<!-- 위젯 시작 { -->
			<h3 class="h3 f-lg en">
				<a href="<?php echo get_pretty_url('video'); ?>">
					<span class="float-right more-plus"></span>
					배너
				</a>
			</h3>
			<hr class="hr"/>
			<div class="px-3 px-sm-0 mt-3 mb-4">
				<?php echo na_widget('data-slider', 'game-5'); ?>
			</div>
			<!-- } 위젯 끝-->
		</div>
	</div>
</div>

</div>
