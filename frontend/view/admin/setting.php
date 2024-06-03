<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="/frontend/aseets/css/navbar.css" />
  <link rel="stylesheet" href="/frontend/aseets/css/conf.css">
  <link rel="stylesheet" href="/frontend/aseets/css/setting.css">
  <title>S.I</title>
</head>

<body>

  <!-- menu-navbar-header -->
  <main>
    <div class="menu">
      <ion-icon name="menu-outline"> <img src="/frontend/aseets/icons/list.svg" alt=""></ion-icon>
      <ion-icon name="close-outline"> <img src="/frontend/aseets/icons/x.svg" alt=""></ion-icon>
    </div>
    <div class="barra-lateral">
      <div>

        <div class="nombre-pagina">
          <ion-icon id="cloud" name="cloud-outline">
            <img id="log-gob" class="img-log" src="/frontend/aseets/img/logo-round.jpg" />
          </ion-icon>
          <span class="nombre">Sistema de Incidencias</span>
        </div>

      </div>

      <nav class="navegacion">
        <ul>
          <li>
            <a id="inbox" href="/frontend/view/admin/index.php">
              <ion-icon name="mail-unread-outline">
                <img class="ico-center" src="/frontend/aseets/icons/house.svg" />
              </ion-icon>
              <span>Pagina principal</span>
            </a>
          </li>

          <li>
            <a class="user" href="/frontend/view/admin/level_admin.php">
              <ion-icon name="mail-unread-outline">
                <img class="icono-inc" src="/frontend/aseets/icons/envelope-paper.svg" />
              </ion-icon>
              <span>Incidencias</span>
            </a>
          </li>


          <li>
            <a class="user" href="/frontend/view/admin/users.php">
              <ion-icon name="star-outline">
                <img class="ico-center" src="/frontend/aseets/icons/person.svg" />
              </ion-icon>
              <span>Usuarios</span>
            </a>
          </li>

          <li>
            <a class="user" href="/frontend/view/admin/chat.php">
              <ion-icon name="paper-plane-outline">
                <img class="ico-center" src="/frontend/aseets/icons/chat.svg" />
              </ion-icon>
              <span>Chat</span>
            </a>
          </li>

          <li>
            <a href="/frontend/view/admin/setting.php">
              <ion-icon name="paper-plane-outline">
                <img class="ico-center" src="/frontend/aseets/icons/gear.svg" />
              </ion-icon>
              <span>Configuracion</span>
            </a>
          </li>


          <li>
            <a href="/frontend/view/logout.php">
              <ion-icon name="document-text-outline">
                <img class="icons-menu ico-center" src="/frontend/aseets/icons/file-lock2.svg" />
              </ion-icon>
              <span>Cerrar sesion</span>
            </a>
          </li>
        </ul>
      </nav>

      <div>
        <div class="linea"></div>



        <div class="info-usuario">
          <div class="nombre-email">
            <span class="nombre">
              <span class="title-profile">Bienvenid@ <?php echo $_SESSION['username'] ?> </span>
              <span class="title-profile">Nivel Admin
              </span>
            </span>
          </div>
        </div>




        <div class="modo-oscuro">
          <div class="info">
            <img class="ico ico-center" src="/frontend/aseets/icons/bx-moon.svg" />
            <span class="dark-text">Modo oscuro</span>
          </div>

          <div class="switch">
            <div class="base">
              <div class="circulo">

              </div>
            </div>
          </div>

        </div>

      </div>

    </div>
  </main>

  <!-- menu-navbar-header -->

  <div class="center">

    <div class="container">
      <div class="topic">Configuraciones</div>
      <div class="content">
        <input type="radio" name="slider" checked id="home" />
        <input type="radio" name="slider" id="blog" />
        <input type="radio" name="slider" id="help" />
        <input type="radio" name="slider" id="code" />
        <input type="radio" name="slider" id="about" />
        <div class="list">
          <label for="home" class="home">
            <!-- <i class="fas fa-home"></i> -->
            <span class="title">Respaldo</span>
          </label>
          <label for="blog" class="blog">
            <span class="icon"><i class="fas fa-blog"></i></span>
            <span class="title">Restauracion</span>
          </label>
          <label for="help" class="help">
            <span class="icon"><i class="far fa-envelope"></i></span>
            <span class="title">Preguntas</span>
          </label>
          <label for="code" class="code">
            <span class="icon"><i class="fas fa-code"></i></span>
            <span class="title">Manual</span>
          </label>
          <label for="about" class="about">
            <span class="icon"><i class="far fa-user"></i></span>
            <span class="title">Informacion</span>
          </label>
          <div class="slider"></div>
        </div>
        <div class="text-content">
          <div class="home text">
            <div class="title">Respaldo</div>
            <p>
              La copia de seguridad, también llamada respaldo o backup, se refiere a la copia de archivos o una bases de datos a un sitio secundario para su preservación en caso de falla del equipo u otra catástrofe.
              El objetivo de un respaldo, es garantizar la recuperación de la información, en caso que haya sido eliminada, dañada o alterada al presentarse alguna contingencia.
            </p>

            <div class="button-container">
              <form action="/backend/php/backup.php" method="post">
                <button onclick="mostrarModalCopiaSeguridad()" type="submit">Generar copia de Seguridad</button>
              </form>

              <button class="btn-elim" type="submit" id="deleteBackupButton" name="deleteBackup">Eliminar copia de seguridad</button>
            </div>


          </div>


          <div class="blog text">
            <div class="title">Restauracion</div>
            <p>
              Restaurar es cargar a una base de datos uno o varios objetos de una base de datos desde una copia de seguridad de esa base de datos o de esos objetos. La restauración sobrescribe cualquier información de la base de datos con la información de la copia de seguridad.
              <br>
              -Recuerda tener una copia de seguridad para realizar la restauracion
            </p>

            <form action="/backend/php/restore.php" method="post">
              <button onclick="mostrarModalRestauracion()" type="submit">Restauracion</button>
            </form>

          </div>
          <div class="help text">
            <div class="title">Preguntas Frecuentes</div>
            <div class="accordion">
              <div class="accordion-content">
                <header>
                  <span> <strong>1. ¿Cómo registro una cuenta?</strong></span>
                  <img src="/frontend/aseets/icons/arrow-down-circle.svg" alt="">
                </header>

                <p class="description">
                  Para registrar una cuenta, ve a la página de registro y completa el formulario con tu información personal. Luego se mostrará una ventana emergente que te indicara si el registro fue exitoso, o si no se te indicara si hay algún problema con la información solicitada.<br>

                </p>
              </div>

              <div class="accordion-content">
                <header>
                  <span><strong>2. ¿Cómo inicio sesión en la aplicación?</strong></span>
                  <img src="/frontend/aseets/icons/arrow-down-circle.svg" alt="">
                </header>

                <p class="description">
                  Para iniciar sesión, ve a la página de inicio de sesión e ingresa tu nombre de usuario y contraseña. Luego, haz clic en el botón de inicio de sesión para acceder a tu cuenta.
                </p>
              </div>

              <div class="accordion-content">
                <header>
                  <span> <strong>3. ¿Cómo puedo recuperar mi contraseña si la olvidé?</strong> </span>
                  <img src="/frontend/aseets/icons/arrow-down-circle.svg" alt="">
                </header>

                <p class="description">
                  Si olvidaste tu contraseña, ve a la página de inicio de sesión y haz clic en el enlace "¿Haz olvidado tu contraseña?" Se te pedirá que ingreses tu correo electrónico y se te enviará un enlace para restablecer tu contraseña.
                </p>
              </div>

              <div class="accordion-content">
                <header>
                  <span><strong>4. ¿Cómo puedo ver las estadísticas de incidencias?</strong></span>
                  <img src="/frontend/aseets/icons/arrow-down-circle.svg" alt="">
                </header>

                <p class="description">
                  Para ver las estadísticas de incidencias, ve a la página principal de la aplicación. Allí encontrarás gráficos o tablas que muestran el número de incidencias resueltas, en curso y pendientes.
                </p>
              </div>

              <div class="accordion-content">
                <header>
                  <span> <strong>5. ¿Cómo puedo agregar una nueva incidencia?</strong> </span>
                  <img src="/frontend/aseets/icons/arrow-down-circle.svg" alt="">
                </header>

                <p class="description">
                  Para agregar una nueva incidencia, ve al módulo de incidencias y haz clic en el botón "Agregar incidencia". Completa el formulario con los detalles de la incidencia y guarda los cambios.
                </p>
              </div>

              <div class="accordion-content">
                <header>
                  <span> <strong>6. ¿Cómo puedo editar una incidencia existente?</strong></span>
                  <img src="/frontend/aseets/icons/arrow-down-circle.svg" alt="">
                </header>

                <p class="description">
                  Para editar una incidencia existente, ve al módulo de incidencias y busca la incidencia que deseas editar. Haz clic en el botón de edición y realiza los cambios necesarios.
                </p>
              </div>

              <div class="accordion-content">
                <header>
                  <span> <strong>7. ¿Cómo puedo cambiar el estado de una incidencia (resolver, en curso, pendiente)?</strong></span>
                  <img src="/frontend/aseets/icons/arrow-down-circle.svg" alt="">
                </header>

                <p class="description">
                  Para cambiar el estado de una incidencia, ve al módulo de incidencias y busca la incidencia en cuestión. Allí encontrarás la opción para cambiar el estado a resolver, en curso o pendiente, dependiendo de tus permisos de usuario.
                </p>
              </div>

              <div class="accordion-content">
                <header>
                  <span> <strong>8. ¿Cómo puedo ver las incidencias asignadas a mí?</strong> </span>
                  <img src="/frontend/aseets/icons/arrow-down-circle.svg" alt="">
                </header>

                <p class="description">
                  Para ver las incidencias asignadas a ti, ve al módulo de incidencias y coloca tu nombre en el buscador. Allí encontrarás una lista de todas las incidencias que te han sido asignadas.
                </p>
              </div>

              <div class="accordion-content">
                <header>
                  <span> <strong>9. ¿Cómo puedo ver todas las incidencias en la aplicación?</strong></span>
                  <img src="/frontend/aseets/icons/arrow-down-circle.svg" alt="">
                </header>

                <p class="description">
                  Para ver todas las incidencias en la aplicación, ve al módulo de incidencias y busca la opción de desacarga en pdf o excel para ver todas las incidencias. Esto te mostrará una lista completa de todas las incidencias en la aplicación.
                </p>
              </div>

              <div class="accordion-content">
                <header>
                  <span> <strong>10. ¿Cómo puedo agregar un nuevo usuario?</strong></span>
                  <img src="/frontend/aseets/icons/arrow-down-circle.svg" alt="">
                </header>

                <p class="description">
                  Para agregar un nuevo usuario, ve al módulo de registro. Completa el formulario con los detalles del nuevo usuario y guarda los cambios.
                </p>
              </div>

              <div class="accordion-content">
                <header>
                  <span><strong>11. ¿Cómo puedo editar los datos de un usuario existente?</strong></span>
                  <img src="/frontend/aseets/icons/arrow-down-circle.svg" alt="">
                </header>

                <p class="description">
                  Para editar los datos de un usuario existente, ve al módulo de usuarios y busca el usuario que deseas editar. Haz clic en el botón de edición y realiza los cambios necesarios.
                </p>
              </div>

              <div class="accordion-content">
                <header>
                  <span> <strong>12. ¿Cómo puedo deshabilitar o bloquear a un usuario?</strong></span>
                  <img src="/frontend/aseets/icons/arrow-down-circle.svg" alt="">
                </header>

                <p class="description">
                  Para deshabilitar o bloquear a un usuario, ve al módulo de usuarios y busca el usuario en cuestión. Allí encontrarás la opción para deshabilitar o bloquear al usuario, dependiendo de tus permisos de usuario.(Solo el admin tiene ese permiso)
                </p>
              </div>

              <div class="accordion-content">
                <header>
                  <span> <strong>13. ¿Cómo puedo ver la lista de usuarios en la aplicación?</strong></span>
                  <img src="/frontend/aseets/icons/arrow-down-circle.svg" alt="">
                </header>

                <p class="description">
                  Para ver la lista de usuarios en la aplicación, ve al módulo de usuarios y encontrarás una lista completa de todos los usuarios registrados en la aplicación.
                </p>
              </div>

              <div class="accordion-content">
                <header>
                  <span> <strong>14. ¿Cómo puedo cambiar mi información personal en la aplicación?</strong></span>
                  <img src="/frontend/aseets/icons/arrow-down-circle.svg" alt="">
                </header>

                <p class="description">
                  Para cambiar tu información personal, ve a la lista de usuario y haz clic en el botón de edición. Allí podrás actualizar tu información personal y guardar los cambios.
                </p>
              </div>

              <div class="accordion-content">
                <header>
                  <span> <strong>15. ¿Cómo puedo utilizar la función de chat en la aplicación?</strong></span>
                  <img src="/frontend/aseets/icons/arrow-down-circle.svg" alt="">
                </header>

                <p class="description">
                  Para utilizar la función de chat, ve al módulo de chat y selecciona la persona con la que deseas chatear. Escribe tu mensaje y envíalo para iniciar la conversación.
                </p>
              </div>

              <div class="accordion-content">
                <header>
                  <span> <strong>16. ¿Cómo puedo realizar un respaldo de la base de datos?</strong></span>
                  <img src="/frontend/aseets/icons/arrow-down-circle.svg" alt="">
                </header>

                <p class="description">
                  Para realizar un respaldo de la base de datos, ve al módulo de configuraciones y busca la opción de respaldo de base de datos. Allí encontrarás la opción para realizar un respaldo de la base de datos.
                </p>
              </div>

              <div class="accordion-content">
                <header>
                  <span> <strong>17. ¿Cómo puedo restaurar la base de datos desde un respaldo?</strong>/span>
                    <img src="/frontend/aseets/icons/arrow-down-circle.svg" alt="">
                </header>

                <p class="description">
                  Para restaurar la base de datos desde un respaldo, ve al módulo de configuraciones y busca la opción de restauración de base de datos. Allí encontrarás la opción para restaurar la base de datos desde un respaldo.
                </p>
              </div>

              <div class="accordion-content">
                <header>
                  <span> <strong>18. ¿Cómo puedo acceder al manual de usuario de la aplicación?</strong></span>
                  <img src="/frontend/aseets/icons/arrow-down-circle.svg" alt="">
                </header>

                <p class="description">
                  Para acceder al manual de usuario de la aplicación, ve al módulo de configuraciones y busca la opción de manual de usuario. Allí encontrarás un enlace para acceder al manual de usuario de la aplicación.
                </p>
              </div>

            </div>


          </div>
          <div class="code text">
            <div class="title">Manual de usuarios</div>

            <p>El manual de usuario de esta aplicación servirá como una guía para los usuarios, proporcionando instrucciones detalladas sobre cómo utilizar todas las funcionalidades de la aplicación de control de incidencias. Incluirá información sobre cómo gestionar incidencias, usuarios y configuraciones, así como también cómo utilizar el chat integrado. Además, el manual ofrecerá consejos y recomendaciones para optimizar el uso de la aplicación y resolver posibles problemas. </p>
            <br>
            <a href="/frontend/aseets/manual/Manual de Usuario.docx" download="/frontend/aseets/manual/Manual de Usuario.docx" class="download-button">Descargar archivo</a>

          </div>
          <div class="about text">
            <div class="title">Informacion</div>
            <p>
              La aplicación de control de incidencias informáticas está diseñada para gestionar y dar seguimiento a fallas de hardware y software en equipos de la Gobernación del Estado Bolívar, específicamente en la Dirección de Informática y Sistemas. Permite a los usuarios registrar nuevas incidencias, asignarlas a personal específico, y visualizar estadísticas sobre el estado de las mismas.
              <!-- Además, facilita la comunicación a través de un sistema de chat integrado y permite la gestión de usuarios, incluyendo la capacidad de agregar, editar y deshabilitar cuentas.--> También ofrece funcionalidades para realizar copias de seguridad y restauraciones de la base de datos, así como acceso a un manual de usuario y preguntas frecuentes para brindar soporte adicional.
            </p>
            <!-- <div class="image-container">
              <img class="info-log" src="/frontend/aseets/img/transparente.png" alt="">
            </div> -->

          </div>
        </div>
      </div>
    </div>
  </div>
  </div>

  <footer>
    <!-- Modal para restauracion exitosa -->
    <div id="modalRestauracion" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <p>Restauración exitosa</p>
      </div>
    </div>
    <!-- Modal para copia de seguridad exitosa -->
    <div id="modalCopiaSeguridad" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <p>Copia de seguridad exitosa</p>
      </div>
    </div>

    <!-- Modal para eliminacion de copia de seguridad exitosa -->
    <!-- <div id="modaldeleteCopiaSeguridad" class="modal">
      <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <p>Eliminación de copia de seguridad exitosa</p>
      </div>
    </div> -->


    <!-- Modal para eliminar copia de seguridad exitosa -->
    <div id="modaldeleteCopiaSeguridad" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <p>Eliminación de copia de seguridad exitosa</p>
      </div>
    </div>

    <!-- Modal para error al eliminar copia de seguridad -->
    <div id="modalErrorEliminar" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <p>Error al intentar eliminar el respaldo.</p>
      </div>
    </div>

    <!-- Modal para respaldo no existente -->
    <div id="modalRespaldoNoExiste" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <p>El respaldo no existe.</p>
      </div>
    </div>

  </footer>
  <!-- scripts -->
  <script src="/frontend/aseets/js/conf.js"></script>

</body>

</html>