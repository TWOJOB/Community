<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

//다음 주소 js
add_javascript(G5_POSTCODE_JS, 0);

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css" media="screen">', 0);

// Clip Modal
na_script('clip');

// 추가폼값을 전부 글내용(wr_content)에 담음
$wr_data = na_unpack($write['wr_content']);

// 필요 배열값
$tel_arr = array('02', '031', '032', '033', '041', '042', '043', '051', '052', '053', '054', '055', '061', '062', '063', '064');

$htel_arr = array('010', '011', '016', '017', '018', '019');

$email_arr = array('naver.com', 'daum.net', 'hanmail.net', 'gmail.com', 'dreamwiz.com', 'empal.com', 'hanmir.com', 'hanafos.com', 'hotmail.com', 'lycos.co.kr', 'nate.com', 'paran.com', 'netian.com', 'yahoo.co.kr', 'kornet.net', 'nownuri.net', 'unitel.co.kr', 'freechal.com', 'korea.com', 'orgio.net', 'chollian.net', 'hitel.net');

// 임시 저장된 글 기능 : AutoSave Modal
if ($is_member)
	na_script('autosave');
?>

<section id="bo_w" class="f-de font-weight-normal mb-4">
    <h2 class="sr-only"><?php echo $g5['title'] ?></h2>

	<!-- 게시물 작성/수정 시작 { -->
	<form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
	<input type="hidden" name="w" value="<?php echo $w ?>">
	<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
	<input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
	<input type="hidden" name="sca" value="<?php echo $sca ?>">
	<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
	<input type="hidden" name="stx" value="<?php echo $stx ?>">
	<input type="hidden" name="spt" value="<?php echo $spt ?>">
	<input type="hidden" name="sst" value="<?php echo $sst ?>">
	<input type="hidden" name="sod" value="<?php echo $sod ?>">
	<input type="hidden" name="page" value="<?php echo $page ?>">
	<input type="hidden" name="wr_content" value="&nbsp;">

	<?php
		$option = '';
		$option_hidden = '';
		if ($is_notice || $is_html || $is_secret || $is_mail) {
			$option_start = PHP_EOL.'<div class="custom-control custom-checkbox custom-control-inline">'.PHP_EOL;
			$option_end = PHP_EOL.'</div>'.PHP_EOL;

			if ($is_html) {
				if ($is_dhtml_editor) {
					$option_hidden .= '<input type="hidden" value="html1" name="html">';
				} else {
					$option .= $option_start;
					$option .= '<input type="checkbox" name="html" value="'.$html_value.'" id="html" onclick="html_auto_br(this);" class="custom-control-input" '.$html_checked.'>';
					$option .= '<label class="custom-control-label" for="html"><span>HTML</span></label>';
					$option .= $option_end;
				}
			}

			if ($is_notice) {
				$option .= $option_start;
				$option .= '<input type="checkbox" name="notice" value="1" id="notice" class="custom-control-input" '.$notice_checked.'>';
				$option .= '<label class="custom-control-label" for="notice"><span>공지</span></label>';
				$option .= $option_end;
			}

			if ($is_secret) {
				if ($is_admin || $is_secret==1) {
					$option .= $option_start;
					$option .= '<input type="checkbox" name="secret" value="secret" id="secret" class="custom-control-input" '.$secret_checked.'>';
					$option .= '<label class="custom-control-label" for="secret"><span>비밀</span></label>';
					$option .= $option_end;
				} else {
					$option_hidden .= '<input type="hidden" name="secret" value="secret">';
				}
			}

			// 게시판 플러그인 사용시
			if (IS_NA_BBS && $is_notice) {
				$as_type_checked = ($write['as_type'] == "1") ? ' checked' : '';
				$option .= $option_start;
				$option .= '<input type="checkbox" name="as_type" value="1" id="as_type" class="custom-control-input" '.$as_type_checked.'>';
				$option .= '<label class="custom-control-label" for="as_type"><span>메인</span></label>';
				$option .= $option_end;
			}

			if ($is_mail) {
				$option .= $option_start;
				$option .= '<input type="checkbox" name="mail" value="mail" id="mail" class="custom-control-input" '.$recv_email_checked.'>';
				$option .= '<label class="custom-control-label" for="mail"><span>답변메일받기</span></label>';
				$option .= $option_end;
			}
		}

		echo $option_hidden;
	?>

	<ul class="list-group mb-3">
	<li class="list-group-item border-top-0">
		<h5 class="font-weight-bold en"><?php echo str_replace($board['bo_subject'], '', $g5['title']) ?></h5>
	</li>

	<?//php if ($is_password) { ?>
		
		<!--
		<li class="list-group-item">
			<div class="form-group row mb-0">
				<label class="col-md-2 col-form-label" for="wr_password">비밀번호<strong class="sr-only">필수</strong></label>
				<div class="col-md-4">
					<input type="password" name="wr_password" id="wr_password" <?//php echo $password_required ?> class="form-control <?//php echo $password_required ?>" maxlength="20">
				</div>
			</div>
		</li>
	-->
	<?//php } ?>

	<!-- input 01 -->
	<li>
		<li>
			<h3 class="py-4 pm-4">
				<span class="text-primary">작품 정보</span>
			</h3>
		</li>
	</li>
	<li class="list-group-item">
		<div class="form-group row mb-0">
			<label class="col-md-2 col-form-label" for="wr_subject">제목<strong class="sr-only">필수</strong></label>
			<div class="col-md-10">
				<input type="text" name="wr_subject" value="<?php echo $subject ?>" id="wr_subject" required class="form-control required" maxlength="255">
			</div>
		</div>
	</li>
	<!-- input 01 -->

	<li>
		<h3 class="py-4 pm-4">
			<span class="text-primary">출품 분야</span>
		</h3>
	</li>	
	<?php if ($is_category) { ?>
		<li class="list-group-item">
			<div class="form-group row mb-0">
				<label class="col-md-2 col-form-label">분류<strong class="sr-only">필수</strong></label>
				<div class="col-md-10">
					<select name="ca_name" id="ca_name" required class="custom-select">
						<option value="">선택하세요</option>
						<?php echo $category_option ?>
					</select>
				</div>
			</div>
		</li>
	<?php } ?>

	<!-- input 02 -->
	<li class="list-group-item">
		<div class="form-group row mb-0">
			<label class="col-md-2 col-form-label">제작년도<strong class="sr-only">필수</strong></label>
			<div class="col-md-10">
                <div class="row na-row">				
			        <div class="col-md-6 na-col">
			        	<div class="input-group">
                            <input type="text" name="wr_data[make_year]" value="<?php echo $wr_data['make_year']; ?>" required class="form-control required">
                            <div class="input-group-append">
    							<span class="input-group-text">년</span>
  							</div>
				        </div>
			        </div>
                    <div class="col-md-6 na-col">
				        <div class="input-group">
                            <input type="text" name="wr_data[make_month]" value="<?php echo $wr_data['make_month']; ?>" required class="form-control required">
					        <div class="input-group-append">
    							<span class="input-group-text">월</span>
  							</div>
				        </div>
			        </div>
                </div>
            </div>    
		</div>
	</li>
	<!-- input 02 -->

	<!-- input 03 -->
	<li class="list-group-item">
		<div class="form-group row mb-0">
			<label class="col-md-2 col-form-label">장르<strong class="sr-only">필수</strong></label>
			<div class="col-md-10">
                <div class="row na-row">				
			        <div class="col-md-6 na-col">
			        	<div class="input-group">
                            <select name="wr_data[genre]" required class="custom-select">
								<option value="">선택하세요</option>
								<option value="극영화"<?php echo get_selected('극영화', $wr_data['genre']);?>>극영화</option>
								<option value="애니메이션"<?php echo get_selected('애니메이션', $wr_data['genre']);?>>애니메이션</option>
								<option value="다큐멘터리"<?php echo get_selected('다큐멘터리', $wr_data['genre']);?>>다큐멘터리</option>
								<option value="기타"<?php echo get_selected('기타', $wr_data['genre']);?>>기타</option>
							</select>
				        </div>
			        </div>
                    <div class="col-md-6 na-col">
				        <div class="input-group">
                            <div class="input-group-prepend">
    							<span class="input-group-text">기타</span>
  							</div>
							<input type="text" name="wr_data[genre_etc]" value="<?php echo $wr_data['genre_etc']; ?>" class="form-control">
				        </div>
			        </div>
                </div>
            </div>    
		</div>
	</li>
	<!-- input 03 -->

	<!-- input 04 -->
	<li class="list-group-item">
		<div class="form-group row mb-0">
			<label class="col-md-2 col-form-label">런닝타임<strong class="sr-only">필수</strong></label>
			<div class="col-md-10">
                <div class="row na-row">				
			        <div class="col-md-6 na-col">
			        	<div class="input-group">
                            <input type="text" name="wr_data[play_h]" value="<?php echo $wr_data['play_h']; ?>" required class="form-control required">
							<div class="input-group-append">
    							<span class="input-group-text">분</span>
  							</div>
				        </div>
			        </div>
                    <div class="col-md-6 na-col">
				        <div class="input-group">
                            <input type="text" name="wr_data[play_m]" value="<?php echo $wr_data['play_m']; ?>" required class="form-control required">
							<div class="input-group-append">
    							<span class="input-group-text">초</span>
  							</div>
				        </div>
			        </div>
                </div>
            </div>    
		</div>
	</li>
	<!-- input 04 -->

	<!-- input 05 -->
	<li class="list-group-item">
		<div class="form-group row mb-0">
			<label class="col-md-2 col-form-label">컬러<strong class="sr-only">필수</strong></label>
			<div class="col-md-10">
                <div class="row na-row">				
			        <div class="col-md-4 na-col">
			        	<div class="input-group">
                            <div class="input-group-prepend">
   								<div class="input-group-text mr-2">
      								<input type="radio" name="wr_data[color]" value="컬러"<?php echo get_checked('컬러', $wr_data['color']);?> required class="mr-2"> 컬러
    							</div>
    							<div class="input-group-text mr-2">
      								<input type="radio" name="wr_data[color]" value="흑백"<?php echo get_checked('흑백', $wr_data['color']);?> required class="mr-2"> 흑백
    							</div>
    							<div class="input-group-text">
      								<input type="radio" name="wr_data[color]" value="혼합"<?php echo get_checked('혼합', $wr_data['color']);?> required class="mr-2"> 혼합
    							</div>
  							</div>
				        </div>
			        </div>

			        <label class="col-md-2 col-form-label">언어<strong class="sr-only">필수</strong></label>
			        <div class="col-md-4 na-col">
			        	<div class="input-group">
                            <div class="input-group-prepend">
   								<div class="input-group-text mr-2">
      								<input type="radio" name="wr_data[lang]" value="한국어"<?php echo get_checked('한국어', $wr_data['lang']);?> required class="mr-2"> 한국어
    							</div>
    							<div class="input-group-text mr-2">
      								<input type="radio" name="wr_data[lang]" value="영어"<?php echo get_checked('영어', $wr_data['lang']);?> required class="mr-2"> 영어
    							</div>
    							<div class="input-group-text">
      								<input type="radio" name="wr_data[lang]" value="외국어"<?php echo get_checked('외국어', $wr_data['lang']);?> required class="mr-2"> 외국어
    							</div>
  							</div>
				        </div>
			        </div>
                </div>
            </div>    
		</div>
	</li>
	<!-- input 05 -->

	<!-- input 06 -->
	<li>
		<h3 class="py-4 pm-4">
			<span class="text-primary">출품자 정보</span>
		</h3>
	</li>	
	<li class="list-group-item">
		<div class="form-group row mb-0">
			<label class="col-md-2 col-form-label">이름<strong class="sr-only">필수</strong></label>
			<div class="col-md-10">
				<div class="row na-row">				
			        <div class="col-md-6 na-col">
			        	<div class="input-group">
                            <div class="input-group-prepend">
    							<span class="input-group-text">국문</span>
  							</div>
                            <input type="text" name="wr_data[director_ko]" value="<?php echo $wr_data['director_ko']; ?>" required class="form-control">
				        </div>
			        </div>
                    <div class="col-md-6 na-col">
				        <div class="input-group">
                            <div class="input-group-prepend">
    							<span class="input-group-text">영문</span>
  							</div>
  							<input type="text" name="wr_data[director_en]" value="<?php echo $wr_data['director_en']; ?>" required class="form-control required">
				        </div>
			        </div>
                </div>	
			</div>
		</div>
	</li>
	<!-- input 06 -->

	<!-- input 07 -->	
	<li class="list-group-item">
		<div class="form-group row mb-0">
			<label class="col-md-2 col-form-label">국적<strong class="sr-only">필수</strong></label>
			<div class="col-md-10">
			    <div class="input-group">
                    <input type="text" name="wr_data[nationality]" value="<?php echo $wr_data['nationality']; ?>" required class="form-control required">
				</div>
            </div>    
		</div>
	</li>
	<!-- input 07 -->

	<!-- input 08 -->	
	<li class="list-group-item">
		<div class="form-group row mb-0">
			<label class="col-md-2 col-form-label">생년월일<strong class="sr-only">필수</strong></label>
			<div class="col-md-10">
				<div class="input-group">
                    <input type="text" name="wr_data[birth]" id="director_birth" value="<?php echo $wr_data['birth']; ?>" required class="form-control required">
                    <div class="input-group-append">
    					<span class="input-group-text"><i class="fa fa-calendar"></i></span>
  					</div>
				</div>     
            </div>    
		</div>
	</li>
	<!-- input 07 -->	

	<!-- input 08 -->
	<li class="list-group-item">
		<div class="form-group row mb-0">
			<label class="col-md-2 col-form-label">전화번호<strong class="sr-only">필수</strong></label>
			<div class="col-md-10">
                <div class="row na-row">				
			        <div class="col-md-4 na-col">
			        	<div class="input-group">
                            <select name="wr_data[tel1]" class="custom-select">
								<?php for($i=0; $i < count($tel_arr); $i++) { ?>
									<option value="<?php echo $tel_arr[$i];?>"<?php echo get_selected($tel_arr[$i], $wr_data['tel1']);?>><?php echo $tel_arr[$i];?></option>
								<?php } ?>
							</select>
				        </div>
			        </div>
                    <div class="col-md-4 na-col">
				        <div class="input-group">
                            <div class="input-group-prepend">
    							<span class="input-group-text">-</span>
  							</div>
							<input type="text" name="wr_data[tel2]" value="<?php echo $wr_data['tel2']; ?>" class="form-control">
				        </div>
			        </div>
			        <div class="col-md-4 na-col">
				        <div class="input-group">
                            <div class="input-group-prepend">
    							<span class="input-group-text">-</span>
  							</div>
							<input type="text" name="wr_data[tel3]" value="<?php echo $wr_data['tel3']; ?>" class="form-control">
				        </div>
			        </div>
                </div>
            </div>    
		</div>
	</li>
	<!-- input 08 -->

	<!-- input 09 -->
	<li class="list-group-item">
		<div class="form-group row mb-0">
			<label class="col-md-2 col-form-label">핸드폰<strong class="sr-only">필수</strong></label>
			<div class="col-md-10">
                <div class="row na-row">				
			        <div class="col-md-4 na-col">
			        	<div class="input-group">
                            <select name="wr_data[htel1]" required class="custom-select">
								<?php for($i=0; $i < count($htel_arr); $i++) { ?>
									<option value="<?php echo $htel_arr[$i];?>"<?php echo get_selected($htel_arr[$i], $wr_data['htel1']);?>><?php echo $htel_arr[$i];?></option>
								<?php } ?>
							</select>
				        </div>
			        </div>
                    <div class="col-md-4 na-col">
				        <div class="input-group">
                            <div class="input-group-prepend">
    							<span class="input-group-text">-</span>
  							</div>
							<input type="text" name="wr_data[htel2]" value="<?php echo $wr_data['htel2']; ?>" required class="form-control required">
				        </div>
			        </div>
			        <div class="col-md-4 na-col">
				        <div class="input-group">
                            <div class="input-group-prepend">
    							<span class="input-group-text">-</span>
  							</div>
							<input type="text" name="wr_data[htel3]" value="<?php echo $wr_data['htel3']; ?>" required class="form-control required">
				        </div>
			        </div>
                </div>
            </div>    
		</div>
	</li>
	<!-- input 09 -->

	<!-- input 10 -->
	<li class="list-group-item">
		<div class="form-group row mb-0">
			<label class="col-md-2 col-form-label">이메일<strong class="sr-only">필수</strong></label>
			<div class="col-md-10">
                <div class="row na-row">				
			        <div class="col-md-4 na-col">
			        	<div class="input-group">
							<input type="text" name="wr_data[email1]" value="<?php echo $wr_data['email1']; ?>" required class="form-control required">
							<div class="input-group-append">
    							<span class="input-group-text">@</span>
  							</div>
				        </div>
			        </div>
                    <div class="col-md-4 na-col">
				        <div class="input-group">
                            <input type="text" name="wr_data[email2]" id="email2" value="<?php echo $wr_data['email2']; ?>" required class="form-control required">
				        </div>
			        </div>
			        <div class="col-md-4 na-col">
				        <div class="input-group">
                            <select name="email_type" class="custom-select" onchange="document.getElementById('email2').value=this.value">
							<option value="">직접입력</option>
							<?php for($i=0; $i < count($email_arr); $i++) { ?>
								<option value="<?php echo $email_arr[$i];?>"<?php echo get_selected($email_arr[$i], $wr_data['email2']);?>><?php echo $email_arr[$i];?></option>
							<?php } ?>
							</select>
				        </div>
			        </div>
                </div>
            </div>    
		</div>
	</li>
	<!-- input 10 -->

	<!-- input 11 -->
	<li class="list-group-item">
		<div class="form-group row mb-0">
			<label class="col-md-2 col-form-label">주소<strong class="sr-only">필수</strong></label>
			<?php //주소 분할
			 list($zip1, $zip2, $zip3, $zip4, $zip5) = explode("|", $wr_data['zip']);
		    ?>
            <div class="col-md-10">
                <div class="row na-row">				
			        <div class="col-md-4 na-col">
			        	<div class="input-group">
						    <input type="text" name="zip1" value="<?php echo $zip1; ?>" id="zip1" required class="form-control" placeholder="우편번호">
						    <span class="input-group-btn">
							    <button type="button" class="btn btn-danger win_zip_find" onclick="win_zip('fwrite', 'zip1', 'zip2', 'zip3', 'zip4', 'zip5');">주소검색</button>
						    </span>
					    </div>
			        </div>
                </div>
                <div class="row na-row py-2 pm-2">				
			        <div class="col-md-12 na-col">
				        <input type="text" name="zip2" value="<?php echo $zip2; ?>" id="zip2" required class="form-control" placeholder="기본주소">
			        </div>
                </div>
                <div class="row na-row pm-2">
                    <div class="col-md-12 na-col">				
			            <div class="input-group">
				            <input type="text" name="zip3" value="<?php echo $zip3; ?>" id="zip3" class="form-control" placeholder="상세주소">
						    <input type="text" name="zip4" value="<?php echo $zip4; ?>" id="zip4" class="form-control" readonly="readonly" placeholder="참고항목">
					    </div>
                    </div>
                </div>
			</div>
			<input type="hidden" name="zip5" value="<?php echo $zip5; ?>" id="zip5">
		</div>
    </li>
	<!-- input 11 -->

	<!-- input 12 -->
	<li class="list-group-item">
		<div class="form-group row mb-0">
			<label class="col-md-2 col-form-label">프리미어<strong class="sr-only">필수</strong></label>
			<div class="col-md-10">
			    <div class="input-group">
                    <div class="input-group-prepend">
   						<div class="input-group-text mr-2">
      						<input type="radio" name="wr_data[premiere]" value="한국 프리미어"<?php echo get_checked('한국 프리미어', $wr_data['premiere']);?> required class="mr-2"> 한국 프리미어
    					</div>
    					<div class="input-group-text mr-2">
      						<input type="radio" name="wr_data[premiere]" value="아시아 프리미어"<?php echo get_checked('아시아 프리미어', $wr_data['premiere']);?> required class="mr-2"> 아시아 프리미어
    					</div>
    					<div class="input-group-text mr-2">
      						<input type="radio" name="wr_data[premiere]" value="월드 프리미어"<?php echo get_checked('월드 프리미어', $wr_data['premiere']);?> required class="mr-2"> 월드 프리미어
    					</div>
    					<div class="input-group-text">
      						<input type="radio" name="wr_data[premiere]" value="인터내셔널 프리미어"<?php echo get_checked('인터내셔널 프리미어', $wr_data['premiere']);?> required class="mr-2"> 인터내셔널 프리미어
    					</div>
  					</div>
				</div>        
            </div>    
		</div>
	</li>
	<!-- input 12 -->

	<!-- input 13 -->	
	<li class="list-group-item">
		<div class="form-group row mb-0">
			<label class="col-md-2 col-form-label">출품작의 수상경력<strong class="sr-only">필수</strong></label>
			<div class="col-md-10">
                <div class="input-group">
					<textarea name="wr_data[prize]" class="form-control"><?php echo $wr_data['prize'];?></textarea>
				</div>
			</div>    
		</div>
	</li>
	<!-- input 13 -->

	<!-- input 14 -->	
	<li class="list-group-item">
		<div class="form-group row mb-0">
			<label class="col-md-2 col-form-label">연출자 필모그래피<strong class="sr-only">필수</strong></label>
			<div class="col-md-10">
                <div class="input-group">
					<textarea name="wr_data[filmography]" class="form-control" required><?php echo $wr_data['filmography'];?></textarea>
				</div>
			</div>    
		</div>
	</li>
	<!-- input 14 -->

	<!-- input 15 -->	
	<li class="list-group-item">
		<div class="form-group row mb-0">
			<label class="col-md-2 col-form-label">출품작 시놉시스<strong class="sr-only">필수</strong></label>
			<div class="col-md-10">
                <div class="input-group">
					<textarea name="wr_data[synopsis]" class="form-control" required><?php echo $wr_data['synopsis'];?></textarea>
				</div>
				<div class="input-group">
					<div class="text-muted" style="margin-top:6px;">
					※ 기재 내용이 많을 시 별지로 첨부 가능합니다.
					</div>
				</div>
			</div>    
		</div>
	</li>
	<!-- input 15 -->

	<!-- input 16 -->	
	<li class="list-group-item">
		<div class="form-group row mb-0">
			<label class="col-md-2 col-form-label">출품작 연출의도<strong class="sr-only">필수</strong></label>
			<div class="col-md-10">
                <div class="input-group">
					<textarea name="wr_data[intention]" class="form-control" required><?php echo $wr_data['intention'];?></textarea>
				</div>
			</div>    
		</div>
	</li>
	<!-- input 16 -->

	<!-- input 17 -->	
	<li class="list-group-item">
		<div class="form-group row mb-0">
			<label class="col-md-2 col-form-label">출품작의 활용<strong class="sr-only">필수</strong></label>
			<div class="col-md-10">
				<div class="mb-2">
					공모된 해당 영상은 다른 플랫폼에서 활용되지 않아야 한다.(예:youtube, kakao tv, daum팟, naver tvcast) 등의 	동영상 플랫폼
				</div>
				<div class="input-group-prepend mb-2">
   					<div class="input-group-text mr-2">
      					<input type="radio" name="wr_data[agree1]" value="1"<?php echo get_checked('1', $wr_data['agree1']);?> required> 약관에 동의합니다.
    				</div>
  				</div>

				<div class="mb-2">
					공모된 영상 중 본선작은 6개월 동안 본 사이트에서 활용 가능합니다.<br> (단, 영상이 노출된 시점부터의 6개월 간 독점 사용 가능)
				</div>
				<div class="input-group-prepend">
   					<div class="input-group-text mr-2">
      					<input type="radio" name="wr_data[agree2]" value="1"<?php echo get_checked('1', $wr_data['agree2']);?> required> 약관에 동의합니다.
    				</div>
  				</div>		
			</div>    
		</div>
	</li>
	<!-- input 17 -->

	<!-- input 18 -->	
	<li class="list-group-item">
		<div class="form-group row mb-0">
			<label class="col-md-2 col-form-label">홍보 목적의 활용<strong class="sr-only">필수</strong></label>
			<div class="col-md-10">      
					<div class="mb-2">
						홍보용 자료(스틸/ 포스터 및 홍보용 영상 클립)들은 영화제 홍보를 위해 사용 및 영화제 홍보용 영상물 제작 동의여부를 표시해주시길 바랍니다.
					</div>
					
					<div class="input-group-prepend mb-2">
   						<div class="input-group-text mr-2">
      						<input type="radio" name="wr_data[agree3]" value="1"<?php echo get_checked('1', $wr_data['agree3']);?> required> 활용에 동의합니다.
    					</div>
    					<div class="input-group-text mr-2">
      						<input type="radio" name="wr_data[agree3]" value="2"<?php echo get_checked('2', $wr_data['agree3']);?> required> 활용에 동의하지 않습니다.
    					</div>
  					</div>

					<div class="mb-2">
						영화제 홍보의 목적으로 DVD 제작 및 무료 배포에 관한 동의 여부를 표시해주시길 바랍니다. 단, DVD를 상업적 유통 경로로 유료 판매할 경우 저작권자와 별도 사전 협의합니다.
					</div>
					<div class="input-group-prepend">
   						<div class="input-group-text mr-2">
      						<input type="radio" name="wr_data[agree4]" value="1"<?php echo get_checked('1', $wr_data['agree4']);?> required> 활용에 동의합니다.
    					</div>
    					<div class="input-group-text mr-2">
      						<input type="radio" name="wr_data[agree4]" value="2"<?php echo get_checked('2', $wr_data['agree4']);?> required> 활용에 동의하지 않습니다.
    					</div>
  					</div>	
				
			</div>    
		</div>
	</li>
	<!-- input 18 -->

	<!-- input 19 -->
	<li>
		<h3 class="py-4 pm-4">
			<span class="text-primary">출품자 정보</span>
		</h3>
	</li>	
	<li class="list-group-item">
		<div class="form-group row mb-0">
			<label class="col-md-2 col-form-label">이름<strong class="sr-only">필수</strong></label>
			<div class="col-md-10">
				<div class="row na-row">				
			        <div class="col-md-12 na-col">
			        	<b>출품 규정에 동의하며 위의 기재 내용이 사실임을 확인합니다.</b>
						<div class="my-3">
							
							<input type="hidden" name="wr_data[ydate]" value="<?php echo date('Y', G5_SERVER_TIME);?>" required class="form-control">	
							<input type="hidden" name="wr_data[mdate]" value="<?php echo date('m', G5_SERVER_TIME);?>" required class="form-control">
							<input type="hidden" name="wr_data[ddate]" value="<?php echo date('d', G5_SERVER_TIME);?>" required class="form-control">

							<b><?php echo date("Y", G5_SERVER_TIME);?>년 <?php echo date("m", G5_SERVER_TIME);?>월 <?php echo date("d", G5_SERVER_TIME);?>일</b>

						</div>
			        </div>
                    <div class="col-md-12 na-col">
				        <div class="input-group">
                            <div class="input-group-prepend">
    							<span class="input-group-text">출품자:이름</span>
  							</div>
  							<input type="text" name="wr_data[name]" value="<?php echo $wr_data['name']; ?>" required class="form-control">
				        </div>
			        </div>
			        <div class="col-md-12 na-col">
				        <div class="input-group my-3">
                            <div class="input-group-prepend">
    							<span class="input-group-text">서명</span>
  							</div>
  							<input type="text" name="wr_data[sign]" value="<?php echo $wr_data['sign']; ?>" required class="form-control input-sm">
				        </div>
			        </div>
                </div>	
			</div>
		</div>
	</li>
	<!-- input 19 -->

	
	<?php if(isset($boset['na_tag']) && $boset['na_tag']) { //태그 ?>
		<li class="list-group-item">
			<div class="form-group row mb-0">
				<label class="col-md-2 col-form-label" for="as_tag">태그</label>
				<div class="col-md-10">
					<input type="text" name="as_tag" id="as_tag" value="<?php echo $write['as_tag']; ?>" class="form-control" placeholder="콤마(,)로 구분하여 복수 태그 등록 가능">
				</div>
			</div>
		</li>
	<?php } ?>

	<?php //관련링크
		if ($is_link) {
			$link_holder = (isset($boset['na_video_link']) && $boset['na_video_link']) ? '유튜브 등 동영상 공유주소 등록시 자동 출력' : 'https://...';
	?>
		<li class="list-group-item">
			<div class="form-group row mb-0">
				<label class="col-md-2 col-form-label">관련 링크</label>
				<div class="col-md-10">
				<?php for ($i=1; $i<=G5_LINK_COUNT; $i++) { ?>
					<div class="<?php echo ($i > 1) ? 'mt-2' : 'mt-0'; ?>">
						<input type="text" name="wr_link<?php echo $i ?>" value="<?php echo $write['wr_link'.$i]; ?>" id="wr_link<?php echo $i ?>" class="form-control" placeholder="<?php echo $link_holder ?>">
					</div>
				<?php } ?>
				</div>
			</div>
		</li>
	<?php } ?>

	<?php if ($is_file) { // 첨부파일 ?>
		<li class="list-group-item">
			<?php
				na_script('fileinput');

				// 칼럼
				$file_col = ($is_file_content) ? 'col-sm-6' : 'col';

				$file_script = "";
				$file_length = -1;
				// 수정의 경우 파일업로드 필드가 가변적으로 늘어나야 하고 삭제 표시도 해주어야 합니다.
				if ($w == "u") {
					for ($i=0; $i<$file['count']; $i++) {
						if ($file[$i]['source']) {
							$file_script .= "add_file('";
							if ($is_file_content) {
								$file_script .= '<div class="'.$file_col.' mt-2 px-2"><input type="text" name="bf_content[]" value="'.addslashes(get_text($file[$i]['bf_content'])).'" class="form-control" placeholder="파일 내용 입력"></div>';
							}

							$file_script .= '<div class="col-12 mt-2 px-2 f-de"><div class="custom-control custom-checkbox">';
							$file_script .= '<input type="checkbox" name="bf_file_del['.$i.']" value="1" id="bf_file_del'.$i.'" class="custom-control-input">';
							$file_script .= '<label class="custom-control-label" for="bf_file_del'.$i.'"><span>'.$file[$i]['source'].'('.$file[$i]['size'].') 파일 삭제 - <a href="'.$file[$i]['href'].'">열기</a></span></label>';
							$file_script .= '</div></div>';
							$file_script .= "');\n";
						} else {
							$file_script .= "add_file('');\n";
						}
					}
					$file_length = $file['count'] - 1;
				}

				if ($file_length < 0) {
					$file_script .= "add_file('');\n";
					$file_length = 0;
				}	
			?>
			<div class="form-group row mb-0">
				<label class="col-md-2 col-form-label">첨부 파일</label>
				<div class="col-md-10">
					<button type="button" onclick="add_file();" class="btn btn-basic">
						<span class="text-muted"><i class="fa fa-plus"></i> 파일 추가</span>
					</button>
					<button type="button" onclick="del_file();" class="btn btn-basic">
						<span class="text-muted"><i class="fa fa-times"></i> 파일 삭제</span>
					</button>

					<table id="variableFiles" class="w-100"></table>

					<script>
					var flen = 0;
					function add_file(delete_code) {

						var upload_count = <?php echo (int)$board['bo_upload_count']; ?>;
						if (upload_count && flen >= upload_count) {
							alert("이 게시판은 "+upload_count+"개 까지만 파일 업로드가 가능합니다.");
							return;
						}

						var objTbl;
						var objNum;
						var objRow;
						var objCell;
						var objContent;
						if (document.getElementById)
							objTbl = document.getElementById("variableFiles");
						else
							objTbl = document.all["variableFiles"];

						objNum = objTbl.rows.length;
						objRow = objTbl.insertRow(objNum);
						objCell = objRow.insertCell(0);

						objContent = '<div class="row mx-n2">';
						objContent += '<div class="<?php echo $file_col ?> mt-2 px-2"><div class="input-group"><div class="input-group-prepend"><label class="input-group-text" for="fwriteFile'+objNum+'">파일 '+objNum+'</label></div>';
						objContent += '<div class="custom-file"><input type="file" name="bf_file[]" class="custom-file-input" title="파일 용량 <?php echo $upload_max_filesize; ?> 이하만 업로드 가능" id="fwriteFile' + objNum + '">';
						objContent += '<label class="custom-file-label" for="imgboxFile" data-browse="선택"></label></div></div></div>';
						if (delete_code) {
							objContent += delete_code;
						} else {
							<?php if ($is_file_content) { ?>
							objContent += '<div class="<?php echo $file_col ?> mt-2 px-2"><input type="text" name="bf_content[]" class="form-control" placeholder="파일 내용 입력"></div>';
							<?php } ?>
							;
						}
						objContent += "</div>";

						objCell.innerHTML = objContent;

						bsCustomFileInput.init();

						flen++;
					}

					<?php echo $file_script; //수정시에 필요한 스크립트?>

					function del_file() {
						// file_length 이하로는 필드가 삭제되지 않아야 합니다.
						var file_length = <?php echo (int)$file_length; ?>;
						var objTbl = document.getElementById("variableFiles");
						if (objTbl.rows.length - 1 > file_length) {
							objTbl.deleteRow(objTbl.rows.length - 1);
							flen--;
						}
					}
					</script>
				</div>
			</div>
		</li>	
		<?php if (IS_NA_BBS) { ?>
			<li class="list-group-item">
				<div class="form-group row mb-0">
					<label class="col-md-2 col-form-label">첨부 사진</label>
					<div class="col-sm-10">
						<p class="form-control-plaintext pt-1 pb-0 float-left">
							<div class="custom-control custom-radio custom-control-inline">
								<input type="radio" id="as_img" name="as_img" value="0"<?php echo (!$write['as_img']) ? ' checked' : ''; ?> class="custom-control-input">
								<label class="custom-control-label" for="as_img"><span>상단 위치</span></label>
							</div>
							<div class="custom-control custom-radio custom-control-inline">
								<input type="radio" id="as_img1" name="as_img" value="1"<?php echo get_checked('1', $write['as_img']) ?> class="custom-control-input">
								<label class="custom-control-label" for="as_img1"><span>하단 위치</span></label>
							</div>
							<div class="custom-control custom-radio custom-control-inline">
								<input type="radio" id="as_img2" name="as_img" value="2"<?php echo get_checked('2', $write['as_img']) ?> class="custom-control-input">
								<label class="custom-control-label" for="as_img2"><span>본문 삽입</span></label>
							</div>
						</p>
						<p class="form-control-plaintext f-de text-muted pb-0">
							본문 삽입시 {이미지:0}, {이미지:1} 형태로 글내용에 입력시 지정 첨부사진이 출력됩니다.
						</p>
					</div>
				</div>
			</li>
		<?php } ?>
	<?php } ?>

	<?php if ($captcha_html) { //자동등록방지  ?>
		<li class="list-group-item">
			<div class="form-group row mb-0">
				<label class="col-md-2 col-form-label">자동등록방지</label>
				<div class="col-md-10 f-small">
					<?php echo $captcha_html; ?>
				</div>
			</div>
		</li>
	<?php } ?>

	</ul>

	<div class="px-3 px-sm-0">
		<div class="row mx-n2">
			<div class="col-6 order-2 px-2">
				<button type="submit" id="btn_submit" accesskey="s" class="btn btn-primary btn-lg btn-block en">작성완료</button>
			</div>
			<div class="col-6 order-1 px-2">
				<a href="<?php echo get_pretty_url($bo_table); ?>" class="btn btn-basic btn-lg btn-block en">취소</a>
			</div>
		</div>
	</div>

	</form>

</section>

<script>
<?php if($write_min || $write_max) { ?>
// 글자수 제한
var char_min = parseInt(<?php echo $write_min; ?>); // 최소
var char_max = parseInt(<?php echo $write_max; ?>); // 최대
check_byte("wr_content", "char_count");

$(function() {
	$("#wr_content").on("keyup", function() {
		check_byte("wr_content", "char_count");
	});
});
<?php } ?>

function html_auto_br(obj) {
	if (obj.checked) {
		result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
		if (result)
			obj.value = "html2";
		else
			obj.value = "html1";
	}
	else
		obj.value = "";
}

function fwrite_submit(f) {

	<?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

	var subject = "";
	var content = "";
	$.ajax({
		url: g5_bbs_url+"/ajax.filter.php",
		type: "POST",
		data: {
			"subject": f.wr_subject.value,
			"content": f.wr_content.value
		},
		dataType: "json",
		async: false,
		cache: false,
		success: function(data, textStatus) {
			subject = data.subject;
			content = data.content;
		}
	});

	if (subject) {
		alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
		f.wr_subject.focus();
		return false;
	}

	if (content) {
		alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
		if (typeof(ed_wr_content) != "undefined")
			ed_wr_content.returnFalse();
		else
			f.wr_content.focus();
		return false;
	}

	if (document.getElementById("char_count")) {
		if (char_min > 0 || char_max > 0) {
			var cnt = parseInt(check_byte("wr_content", "char_count"));
			if (char_min > 0 && char_min > cnt) {
				alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
				return false;
			}
			else if (char_max > 0 && char_max < cnt) {
				alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
				return false;
			}
		}
	}

	<?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

	<?php if($w == '') { ?>
		if(confirm("접수완료 후 수정하실 수 없습니다.\n\n접수하시겠습니까?")) {
			document.getElementById("btn_submit").disabled = "disabled";
			return true;
		} else {
			return false;
		}
	<?php } else { ?>
		document.getElementById("btn_submit").disabled = "disabled";
		return true;
	<?php } ?>

}

$(function(){
	$("#director_birth").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", yearRange: "c-100:c" });
	$("#wr_content").addClass("form-control input-sm write-content");
});

</script>