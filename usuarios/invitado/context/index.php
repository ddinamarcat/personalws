<!-- Sitio web desarrollado por Daniel Dinamarca Tosso -->
<!DOCTYPE html>
<html>
<head>
  <title>Daniel Dinamarca T.</title>
  <!-- Favicon -->
  <link rel="icon" href="img/favicon.ico" type="image/x-icon"/>
  <!-- jQuery slim min 3.2.1 -->
	<script src="js/jquery.slim.min.js"></script>
  <!-- Vista para dispositivos moviles -->
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <!-- Codificacion usada -->
  <meta charset="utf-8"/>
  <meta http-equiv="Content-Type" content="text/html"/>
  <!-- Script para volver arriba -->
  <!-- Script para cargar context Manager -->
  <script type="text/javascript" src="js/contextManager.js"></script>
  <script type="text/javascript" src="js/invitado.js"></script>
  <script type="text/javascript" src="js/validator.js"></script>
  <!-- Script para cargar context Manager acercade-->
  <!-- Script para limitar movimiento del calendario de eventos-->
  <!-- Script para generar ventana modal para eventos y noticias -->

  <!-- Hoja estilo Layout1 -->
  <script type="text/javascript" src="js/responsive.js"></script>

</head>
<body>
<header>
  <div id="header-grid">

    <div>
      <a href="#principal" class="main-menu-element" templateId="principal" mark="0"><img id="logo" src="img/ddt_logo.svg" alt="Daniel Dinamarca Logo"/></a>
    </div>
    <div class="menu-mobile">
        <span class="menu"><img src="img/nav.svg" alt="" onclick="menuHandler()"/></span>
    </div>
    <div>
        <nav id="top-menu" class="menum-inactivo" >
            <ul id="botones-menu-principal">
                <li class="no-actual main-menu-element" templateId="quiensoy" mark="1">
                    <a href="#">Quién soy</a>
                </li>
                <li class="no-actual main-menu-element" templateId="experiencia" mark="1">
                    <a href="#">Experiencia</a>
                </li>
                <li class="no-actual main-menu-element" templateId="educacion" mark="1">
                    <a href="#">Educaci&oacute;n</a>
                </li>
                <li class="no-actual main-menu-element" templateId="tecnologias" mark="1">
                    <a href="#">Tecnolog&iacute;as</a>
                </li>
                <li class="no-actual main-menu-element" templateId="creencias" mark="1">
                    <a href="#">Creencias</a>
                </li>
                <li class="no-actual main-menu-element" templateId="hobbies" mark="1">
                    <a href="#">Hobbies</a>
                </li>
                <li class="no-actual main-menu-element" templateId="contactame" mark="1">
                    <a href="#">Cont&aacute;ctame</a>
                </li>
            </ul>
        </nav>
    </div>
    <div>
        <input id="login-button" type="button" Value="LOGIN" onclick="loginManager.showLogin();"/>
    </div>

  </div>
</header>

<div id="contenido" class="c-desactivado">
</div>
<template id="principal">
	<?php include_once("principal.php"); ?>
</template>
<template id="membresia">
	<?php include_once("quiensoy.php"); ?>
</template>
<template id="acercade">
    <?php include_once("experiencia.php"); ?>
</template>
<template id="eventos">
    <?php include_once("educacion.php"); ?>
</template>
<template id="comunidad">
    <?php include_once("tecnologias.php"); ?>
</template>
<template id="startupchile">
    <?php include_once("creencias.php"); ?>
</template>
<template id="noticias">
    <?php include_once("hobbies.php"); ?>
</template>
<template id="visita">
    <?php include_once("contactame.php"); ?>
</template>
<template id="login-form">
    <div class="login-container">
        <div class="input-login">
            <img src="img/ddt_logo_azul.svg"/>
        </div>
        <form method="post" submitId="login-boton" onkeyup="validator.activateSubmit(this)" action="lib/LoginManager.php" class="login-f">
            <div class="input-login">
                <input name="user" placeholder="Ingrese su correo" type="text" autocomplete="off" validate="email" required/>
            </div>
            <div class="input-login">
                <input name="pass" placeholder="Ingrese su contraseña" type="password" autocomplete="off" validate="password" required/>
            </div>
            <div class="input-login">
                <button id="login-boton" class="boton-amarillo boton-login" type="submit" name="form-enviar" validate="submit" value="Submit" disabled>Enviar</button>
            </div>
        </form>
    <div>
</template>
<section id="modal-section" class="modal-hidden fadeout-modal hidden">
	<div id="modal-div">
        <img src="img/boton-cerrar.png" alt="Cerrar" class="boton-cerrar" onclick="modalManager.hideModal();"/>
		<div id="modal-content">
		</div>
	</div>
</section>

<footer>

  <div>
    <p>Todos los derechos reservados a @DDINAMARCAT / Dise&ntilde;o y programaci&oacute;n propios</p>
  </div>
  <div>
    <div class="sm-icon yt-icon"><a href="https://www.youtube.com/channel/UC9tahWpTT73pZoXdZQU1QCw" target="_blank"><img src="img/youtube_icon_after.svg" alt="Youtube"/></a></div>
    <div class="sm-icon fb-icon"><a href="https://www.facebook.com/ddinamarcat" target="_blank"><img src="img/fb_icon_after.svg" alt="Facebook"/></a></div>
    <div class="sm-icon tw-icon"><a href="https://twitter.com/ddinamarca" target="_blank"><img src="img/twitter_icon_after.svg" alt="Twitter"/></a></div>
    <div class="sm-icon ig-icon"><a href="https://www.instagram.com/ddinamarcat/" target="_blank"><img src="img/instagram_icon_after.svg" alt="Instagram"/></a></div>
    <div class="sm-icon li-icon"><a href="https://www.linkedin.com/in/ddinamarcat/" target="_blank"><img src="img/linkedin_icon_after.svg" alt="Instagram"/></a></div>
  </div>

</footer>

</body>
</html>
