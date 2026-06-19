<?php require_once('main.php'); ?>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>纯 · 色</title>
		<?php
			$res_prefix = "";
			if (isset($_GET['subdir'])){
				$res_prefix = "../";
			}
		?>

		<!-- Material Design Web -->
		<link href="https://cdn.jsdelivr.net/npm/material-components-web@14.0.0/dist/material-components-web.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/material-components-web@14.0.0/dist/material-components-web.min.js"></script>

		<!-- Material Symbols -->
		<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />

		<!-- Fonts -->
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Noto+Serif+SC:300&display=swap" rel="stylesheet">

		<!-- Original CSS -->
		<link href="<?php echo $res_prefix; ?>css/style.css" type='text/css' rel='stylesheet'>

		<!-- Original JS -->
		<script src="<?php echo $res_prefix; ?>js/vue.js"></script>
		<script src="<?php echo $res_prefix; ?>js/jquery-3.4.1.min.js"></script>
		<script src="<?php echo $res_prefix; ?>js/main.js"></script>
	</head>
	<style id="now_color_definition">
		:root{
			--color: #5e72e4;
			--color-rgb: 94, 114, 228;
		}
	</style>
	<style id="mobile_color_group_container_padding_definition">
		:root{
			--mobile-color-group-container-padding: 0px;
		}
	</style>
	<script>
		<?php
			$notfound = "false";
			$themecolor = "#5e72e4";
			if (!isset($_GET['id']) || empty($_GET['id'])){
				$colorjson = $default_color_json;
			}else{
				if (!check_id($_GET['id'])){
					$colorjson = "[]";
					$notfound = "true";
				}else{
					$sql = "SELECT * FROM palettes where id = '" . esc_str($_GET['id']) . "'";
					$sqlres = mysqli_query($conn, $sql);
					$data = mysqli_fetch_assoc($sqlres);
					if (mysqli_num_rows($sqlres) == 0){
						$colorjson = "[]";
						$notfound = "true";
					}else{
						$themecolor = $data['themecolor'];
						$colorjson = $data['color_json'];
					}
				}
			}
		?>
		var color_json = <?php echo $colorjson; ?>;
		var themecolor = "<?php echo $themecolor; ?>";
		$("#now_color_definition").html(":root{--color: " + themecolor + "; --color-rgb: " + hex2str(themecolor) + ";}");
	</script>
	<body>
		<div id="app">
			<!-- ===== Material App Bar ===== -->
			<div class="pc-app-bar">
				<span class="material-symbols-outlined pc-app-bar-icon">palette</span>
				<span class="pc-app-bar-title">纯·色</span>
				<span class="pc-app-bar-subtitle">Pure Colors</span>
				<span class="pc-app-bar-spacer"></span>
				<a class="pc-app-bar-github" href="https://github.com/GGapa/purecolor" target="_blank">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 530.97 517.81" width="22" height="22">
						<path d="M265.47,0C118.88,0,0,118.85,0,265.47,0,382.75,76.06,482.24,181.57,517.35c13.27,2.44,18.12-5.76,18.12-12.79,0-6.31-.23-23-.36-45.15-73.85,16-89.43-35.59-89.43-35.59C97.83,393.16,80.42,385,80.42,385c-24.1-16.47,1.83-16.13,1.83-16.13,26.64,1.87,40.66,27.35,40.66,27.35,23.68,40.57,62.14,28.85,77.26,22.06,2.42-17.16,9.28-28.85,16.86-35.49-58.95-6.7-120.93-29.47-120.93-131.2,0-29,10.35-52.67,27.33-71.23-2.73-6.72-11.84-33.71,2.6-70.25,0,0,22.29-7.14,73,27.21a251.54,251.54,0,0,1,132.93,0C382.65,103,404.9,110.1,404.9,110.1c14.49,36.54,5.37,63.53,2.64,70.25,17,18.56,27.29,42.25,27.29,71.23,0,102-62.07,124.42-121.21,131,9.53,8.2,18,24.4,18,49.16,0,35.49-.33,64.12-.33,72.83,0,7.09,4.79,15.35,18.26,12.76C455,482.15,531,382.72,531,265.47,531,118.85,412.1,0,265.47,0Z" transform="translate(0)" style="fill: #EADDFF;"></path>
					</svg>
				</a>
			</div>

			<!-- ===== Sidebar ===== -->
			<div class="pc-sidebar" v-if="notfound == false">
				<div class="pc-color-card">
					<div class="pc-color-preview" :style="'background-color: ' + color"></div>
					<div class="pc-color-hex">{{ color_uppercase }}</div>
					<div class="pc-color-values">
						<div class="pc-color-value-row">
							<span class="pc-color-label">RGB</span>
							<span>{{ color_rgb_array['R'] }} , {{ color_rgb_array['G'] }} , {{ color_rgb_array['B'] }}</span>
						</div>
						<div class="pc-color-value-row">
							<span class="pc-color-label">HEX</span>
							<span>{{ color_uppercase }}</span>
						</div>
						<div class="pc-color-value-row">
							<span class="pc-color-label">HSL</span>
							<span>{{ Math.round(color_hsl_array['h'] * 360)}}° , {{ Math.trunc(color_hsl_array['s'] * 100)}}<span class="hsl-dec">{{ ((color_hsl_array['s'] * 100) % 1).toFixed(1).replace("0.", ".") }}</span>% , {{ Math.trunc(color_hsl_array['l'] * 100)}}<span class="hsl-dec">{{ ((color_hsl_array['l'] * 100) % 1).toFixed(1).replace("0.", ".") }}</span>%</span>
						</div>
						<div class="pc-color-value-row">
							<span class="pc-color-label">Gray</span>
							<span>{{ vhex2gray(color) }}</span>
						</div>
					</div>
				</div>
				<button class="pc-fab" onclick="randomcolor()" title="随机颜色">
					<span class="material-symbols-outlined">shuffle</span>
					<span class="pc-fab-text">随机</span>
				</button>
			</div>

			<!-- Original hidden elements (kept for JS compatibility) -->
			<div id="head" style="display:none;">
				<div id="title">
					<span id="subtitle">Pure Colors</span>
					纯·色
					<a class="github-link" href="https://github.com/GGapa/purecolor" target="_blank"></a>
				</div>
				<div id="info">
					<div id="rgb" class="colorinfo-item"><span class="colorinfo-title">RGB</span>{{ color_rgb_array['R'] }} , {{ color_rgb_array['G'] }} , {{ color_rgb_array['B'] }}</div>
					<div id="hex" class="colorinfo-item"><span class="colorinfo-title">HEX</span>{{ color_uppercase }}</div>
					<div id="hsl" class="colorinfo-item"><span class="colorinfo-title">HSL</span>{{ Math.round(color_hsl_array['h'] * 360)}}° , {{ Math.trunc(color_hsl_array['s'] * 100)}}<span class="hsl-dec">{{ ((color_hsl_array['s'] * 100) % 1).toFixed(1).replace("0.", ".") }}</span>% , {{ Math.trunc(color_hsl_array['l'] * 100)}}<span class="hsl-dec">{{ ((color_hsl_array['l'] * 100) % 1).toFixed(1).replace("0.", ".") }}</span>%</div>
					<div id="gray" class="colorinfo-item"><span class="colorinfo-title">Gray</span>{{ vhex2gray(color) }}</div>
				</div>
			</div>

			<div id="content">
				<?php if (isset($sqlres)) { 
						if (mysqli_num_rows($sqlres) > 0) { ?>
					<div class="palette-info palette-info-material">
						<div class="palette-info-title"><?php echo $data['title'];?></div>
						<div class="palette-info-author">By <?php echo $data['author'];?></div>
						<div class="palette-info-description"><?php echo $data['description'];?></div>
					</div>
				<?php }
					} ?>
				<div v-for="group in list" class="color-group color-group-material" v-if="notfound == false">
					<div class="color-group-title color-group-title-material">{{ group.name }}</div>
					<div class="color-group-container">
						<div v-for="item in sorted(group.colors , group.autosort)" class="color-item color-item-material" v-bind:style="'--item-color: ' + item.hex + '; --item-color-rgb: ' + colorhex2str(item.hex) + '; --item-shadow-color-rgb: ' + colorhex2str(item.hex) + ';'" v-bind:hex="item.hex" v-bind:class="{current: color == item.hex , toolight: vistoolight(item.hex) , 'color-group-subtitle': (item.hex == 'subtitle')}">
							<div v-if="item.hex != 'subtitle'" v-bind:style="{background: item.hex}" class="color-preview color-preview-material" v-on:click="vchangecolor(item.hex);"></div>
							<div class="color-name color-name-material">{{ (item.name == '' || item.name == undefined) ? item.hex : item.name }}</div>
						</div>
					</div>
				</div>
				<div class="notfound notfound-material" v-if="notfound == true">
					404<div class="notfound-tip">好像找不到这个色板...</div>
				</div>
			</div>
		</div>
		<div id="wave_container">
			<div id="wave">
				<svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
					<defs>
						<path id="gentle-wave" class="transition-delay" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"/>
					</defs>
					<g class="parallax">
						<use class="transition-delay" xlink:href="#gentle-wave" x="48" y="0"/>
						<use class="transition-delay" xlink:href="#gentle-wave" x="48" y="3"/>
						<use class="transition-delay" xlink:href="#gentle-wave" x="48" y="5"/>
						<use class="transition-delay" xlink:href="#gentle-wave" x="48" y="7"/>
					</g>
				</svg>
			</div>
			<div id="wave_filler" class="transition-delay"></div>
		</div>
		<div id="mask"></div>
		<div id="mask2"></div>

	</body>
</html>

<script>
	var app = new Vue({
		el: '#app',
		data: {
			color: themecolor,
			list: color_json,
			notfound: <?php echo $notfound ?>,
			need_password: false
		},
		watch: {
			color: function (newcolor, oldcolor) {
				$("#now_color_definition").html(":root{--color: " + newcolor + "; --color-rgb: " + hex2str(newcolor) + ";}");
				// Update Material color preview
				document.documentElement.style.setProperty('--pc-preview-color', newcolor);
			}
		},
		computed: {
			color_uppercase: function () {
				return this.color.toUpperCase();
			},
			color_rgb: function () {
				return hex2str(this.color);
			},
			color_rgb_array: function () {
				return hex2rgb(this.color);
			},
			color_hsl_array: function () {
				let rgb_array = hex2rgb(this.color);
				return rgb2hsl(rgb_array['R'], rgb_array['G'], rgb_array['B']);
			}
		},
		methods:{
			colorhex2str: function (color) {
				return hex2str(color);
			},
			vchangecolor: function(color){
				changecolor(color);
			},
			vistoolight: function(color){
				return istoolight(color);
			},
			vhex2gray: function(hex){
				return hex2gray(hex);
			},
			sorted: function (numbers , autosort) {
				if (autosort != true){
					return numbers;
				}
				return numbers.slice().sort(function (a,b) {
					if (a.hex == "subtitle" || b.hex == "subtitle"){
						return false;
					}
					a = a.hex;
					b = b.hex;
					let rgb_array1 = hex2rgb(a);
					let rgb_array2 = hex2rgb(b);
					let hsl1 = rgb2hsl(rgb_array1['R'], rgb_array1['G'], rgb_array1['B']);
					let hsl2 = rgb2hsl(rgb_array2['R'], rgb_array2['G'], rgb_array2['B']);
					return hsl1['h'] - hsl2['h'];
				});
			}
		}
	});
	function changecolor(color){
		if ($("body").hasClass("color-refreshing")){
			return;
		}
		app.color = color;
		$("body").removeClass("color-refreshing");
		// Toggle .light-bg class on app bar and FAB based on color brightness
		var appBar = document.querySelector('.pc-app-bar');
		var fab = document.querySelector('.pc-fab');
		if (hex2gray(color) > 186) {
			if (appBar) appBar.classList.add('light-bg');
			if (fab) fab.classList.add('light-bg');
		} else {
			if (appBar) appBar.classList.remove('light-bg');
			if (fab) fab.classList.remove('light-bg');
		}
		setTimeout(function(){
			$("body").addClass("color-refreshing");
			$("body").removeClass("toolight");
			if (istoolight(color)){
				$("body").addClass("toolight");
			}
			setTimeout(function(){
				$("body").removeClass("color-refreshing");
			}, 1100);
		} , 50);
	}
	$(window).resize(function(){
		let padding = ((document.body.clientWidth - 25 * 2) % (50 + 50)) / 2;
		$("#mobile_color_group_container_padding_definition").html(':root{--mobile-color-group-container-padding: ' + padding + 'px;}');
	});
	$(window).trigger("resize");

	// ===== Material Ripple Effect =====
	document.addEventListener('click', function(e) {
		var target = e.target.closest('.color-item-material');
		if (!target) return;

		var ripple = document.createElement('span');
		var rect = target.getBoundingClientRect();
		var size = Math.max(rect.width, rect.height);
		var x = e.clientX - rect.left - size / 2;
		var y = e.clientY - rect.top - size / 2;

		ripple.style.cssText = 'position:absolute;width:' + size + 'px;height:' + size + 'px;left:' + x + 'px;top:' + y + 'px;background:rgba(255,255,255,0.35);border-radius:50%;transform:scale(0);animation:pc-ripple 0.5s ease-out;pointer-events:none;z-index:1;';
		target.appendChild(ripple);
		setTimeout(function() { ripple.remove(); }, 500);
	});

	// Inject ripple keyframe
	var pcStyle = document.createElement('style');
	pcStyle.textContent = '@keyframes pc-ripple{to{transform:scale(2.5);opacity:0;}}';
	document.head.appendChild(pcStyle);

	// Apply initial light-bg class based on starting theme color
	(function(){
		var appBar = document.querySelector('.pc-app-bar');
		var fab = document.querySelector('.pc-fab');
		if (hex2gray(themecolor) > 186) {
			if (appBar) appBar.classList.add('light-bg');
			if (fab) fab.classList.add('light-bg');
		}
	})();
</script>
