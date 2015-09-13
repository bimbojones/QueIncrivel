<?php include_once "layout/header.php"?>
<div id="main" class="container-fluid">
	<div class="container">
		<!-- Place somewhere in the <body> of your page -->
		<div class="flexslider">
			<ul class="slides">
				<li><img src="<?=$path ?>images/gallery/1.jpg" /></li>
				<li><img src="<?=$path ?>images/gallery/2.jpg" /></li>
				<li><img src="<?=$path ?>images/gallery/3.jpg" /></li>
				<li><img src="<?=$path ?>images/gallery/4.jpg" /></li>
			</ul>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-9">
				<div class="row">
					<div class="col-md-12">
						<div class="post">
							<a href="<?= $path ?>p"><div class="image-container">
									<h2>Nam vitae cursus ligula</h2>
									<img src="<?=$path ?>images/gallery/4.jpg" />
								</div></a> <span>Lorem ipsum dolor sit amet, consectetur
								adipiscing elit. Duis elementum tincidunt imperdiet. Nam non
								rhoncus lectus, eget congue dui. Vestibulum id nisl non sem
								auctor pellentesque nec vel velit. Donec rutrum porttitor lectus
								sit amet cursus. Ut iaculis venenatis ante dapibus accumsan.
								Nullam quis tincidunt augue. Nam vitae cursus ligula. Cras at
								velit quis mauris laoreet porttitor.</span>
						</div>

					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-12">
						<div class="post">
							<div class="image-container">
								<h2>Nam vitae cursus ligula</h2>
								<img src="<?=$path ?>images/gallery/3.jpg" />
							</div>
							<span>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
								Duis elementum tincidunt imperdiet. Nam non rhoncus lectus, eget
								congue dui. Vestibulum id nisl non sem auctor pellentesque nec
								vel velit. Donec rutrum porttitor lectus sit amet cursus. Ut
								iaculis venenatis ante dapibus accumsan. Nullam quis tincidunt
								augue. Nam vitae cursus ligula. Cras at velit quis mauris
								laoreet porttitor.</span>
						</div>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-12">
						<div class="post">
							<div class="image-container">
								<h2>Nam vitae cursus ligula</h2>
								<img src="<?=$path ?>images/gallery/2.jpg" />
							</div>
							<span>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
								Duis elementum tincidunt imperdiet. Nam non rhoncus lectus, eget
								congue dui. Vestibulum id nisl non sem auctor pellentesque nec
								vel velit. Donec rutrum porttitor lectus sit amet cursus. Ut
								iaculis venenatis ante dapibus accumsan. Nullam quis tincidunt
								augue. Nam vitae cursus ligula. Cras at velit quis mauris
								laoreet porttitor.</span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="row">
					<div class="col-md-12">
						<div class="box">
							<h2>Suzana Saboya</h2>
							<img src="<?=$path ?>images\suzana.jpg" />
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis
								elementum tincidunt imperdiet. Nam non rhoncus lectus, eget
								congue dui. Vestibulum id nisl non sem auctor pellentesque nec
								vel velit.</p>
						</div>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-12">
						<div class="box">
							<div class="panel">
								<div class="front">
									<h2>Contactos</h2>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
										Duis elementum tincidunt imperdiet. Nam non rhoncus lectus,
										eget congue dui. Vestibulum id nisl non sem auctor
										pellentesque nec vel velit.</p>
									<button onclick="javascript:$('.panel').addClass('flip')">Enviar
										email</button>
								</div>
								<form method="post" class="back">
									<h2>Contactos</h2>
									<p>
										<input id="f-name" name="f-name" type="text"
											placeholder="name">
									</p>
									<p>
										<input id="f-email" name="f-email" type="text"
											placeholder="email">
									</p>
									<p>
										<textarea id="f-msg" name="f-msg" placeholder="Sua mensagem"> </textarea>
									</p>
									<input type="button"
										onclick="javascript:$('.panel').removeClass('flip')"
										value="Enviar">
								</form>
							</div>
						</div>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-12">
						<div class="box">Nullam quis tincidunt augue. Nam vitae cursus
							ligula.</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
<?php include_once "layout/footer.php"?>