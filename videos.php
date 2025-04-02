<?php
include "./admin/php/conexion.php";

$registrosPorPagina = 2;

// Página actual
if (isset($_GET['page'])) {
    $paginaActual = $_GET['page'];
} else {
    $paginaActual = 1;
}

// Calcular el desplazamiento (offset) para la consulta SQL
$offset = ($paginaActual - 1) * $registrosPorPagina;

// Consulta SQL con limit, offset y búsqueda
$searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($conexion, $_GET['search']) : '';
$sql = "SELECT * FROM videos WHERE nombre LIKE '%$searchTerm%' LIMIT $offset, $registrosPorPagina";
$resultado = mysqli_query($conexion, $sql);
$sql2 = "SELECT COUNT(*) AS totalCategorias FROM videos";
$resultado2 = mysqli_query($conexion, $sql2);
$row = mysqli_fetch_assoc($resultado2);
$totalCategorias = $row['totalCategorias'];
$totalBotones = round($totalCategorias / $registrosPorPagina);

// Calcular el número total de páginas
$totalRegistros = mysqli_num_rows($resultado2); // Reemplaza con la cantidad total de registros en tu tabla
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El club del Verso</title>

    <!-- Styles -->

    <link rel="stylesheet" href="./cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />

    <link rel="stylesheet" href="app/dist/aos.css">
    <link rel="stylesheet" href="app/dist/animate.css">
    <link rel="stylesheet" href="app/dist/app.css">
    <!-- end Styles -->

    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="assets/images/logo/favicon.png">
    <link rel="apple-touch-icon-precomposed" href="assets/images/logo/favicon.png">

</head>

<body class="home-main header-fixed">

    <div class="wrapper">

        <div class="preloader">
            <div class="clear-loading loading-effect-2">
                <span></span>
            </div>
        </div>

        <!-- Header -->
        <?php include("./layouts/header.php"); ?>
        <!-- Header -->

        <section class="page-title">
            <div class="shape"></div>
            <div class="shape right s3"></div>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title__body">
                            <div class="page-title__main">
                                <h4 class="title">videos</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Lista -->
        <section class="bloglist">
            <div class="container">
                <div class="row">
                    <div class="bloglist__main">
                        <div class="list">

                            <?php while ($f = mysqli_fetch_array($resultado)) {
                                parse_str(parse_url($f['link'], PHP_URL_QUERY), $videoParams);
                                $videoId = $videoParams['v'];
                                $thumbnailUrl = "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";
                            ?>

                                <div class="blog-box-2">
                                    <div class="image">
                                        <a href="<?php echo $f['link']; ?>" class="popup-youtube">
                                            <img src="<?php echo $thumbnailUrl; ?>" alt="Video Thumbnail">
                                        </a>
                                    </div>

                                    <div class="content">
                                        <div class="meta">
                                            <a href="">
                                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="..." stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                                <?php echo $f['fecha']; ?>
                                            </a>
                                        </div>
                                        <a class="title" href=""><?php echo $f['nombre']; ?></a>
                                        <p class="text"><?php
                                                        $res = $conexion->query("SELECT nombre FROM categorias WHERE id = " . $f['id_categoria']);
                                                        if ($categoria = mysqli_fetch_array($res)) {
                                                            echo $categoria['nombre'];
                                                        }
                                                        ?></p>
                                        <div class="watch-video__main">
                                            <div class="main">
                                                <div class="wrap-video">
                                                    <a href="<?php echo $f['link']; ?>" class="popup-youtube">
                                                        <svg width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M14.853 7.25168C16.2247 8.01369 16.2247 9.9863 14.853 10.7483L2.97129 17.3493C1.63822 18.0899 -7.9231e-07 17.1259 -7.25651e-07 15.601L-1.48576e-07 2.39903C-8.19178e-08 0.874059 1.63822 -0.0898765 2.97129 0.650714L14.853 7.25168Z" fill="#D9D9D9" />
                                                            <path d="M14.853 7.25168C16.2247 8.01369 16.2247 9.9863 14.853 10.7483L2.97129 17.3493C1.63822 18.0899 -7.9231e-07 17.1259 -7.25651e-07 15.601L-1.48576e-07 2.39903C-8.19178e-08 0.874059 1.63822 -0.0898765 2.97129 0.650714L14.853 7.25168Z" fill="url(#paint0_linear_787_6121)" />
                                                            <defs>
                                                                <linearGradient id="paint0_linear_787_6121" x1="43.9319" y1="31.9348" x2="38.9828" y2="-12.545" gradientUnits="userSpaceOnUse">
                                                                    <stop offset="0.164688" stop-color="#DEC7FF" />
                                                                    <stop offset="0.855177" stop-color="#ffc107" />
                                                                </linearGradient>
                                                            </defs>
                                                        </svg>
                                                    </a>
                                                </div>

                                                <h5>Ver video</h5>
                                            </div>
                                        </div>
                                        <div style="font-size: 10px; color: #cccccc;line-break: anywhere;word-break: normal;overflow: hidden;white-space: nowrap;text-overflow: ellipsis; font-family: Interstate,Lucida Grande,Lucida Sans Unicode,Lucida Sans,Garuda,Verdana,Tahoma,sans-serif;font-weight: 100;"><a href="" title="<?php echo $f['nombre']; ?>" target="_blank" style="color: #cccccc; text-decoration: none;"><?php echo $f['autor']; ?></a> · <a href="" title="" target="_blank" style="color: #cccccc; text-decoration: none;"></a></div>
                                    </div>
                                </div>

                            <?php
                            }
                            ?>
                            <div class="pagination">
                                <ul>
                                    <?php if ($paginaActual > 1) : ?>
                                        <li>
                                            <a href="?page=<?php echo $paginaActual - 1; ?>&search=">
                                                <svg width="10" height="15" viewBox="0 0 10 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1.1212 7.46543L7.56346 13.8092C7.8205 14.0662 8.23613 14.0662 8.49317 13.8092L8.88144 13.4209C9.13848 13.1639 9.13848 12.7482 8.88144 12.4912L3.2869 7.00059L8.87598 1.50997C9.133 1.25293 9.133 0.837303 8.87598 0.580281L8.48769 0.191991C8.23067 -0.0650311 7.81504 -0.0650311 7.558 0.191991L1.11578 6.53574C0.864303 6.79278 0.864302 7.20841 1.1212 7.46543Z" fill="white" fill-opacity="0.5" />
                                                </svg>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php
                                    $maxButtons = 4; // Número máximo de botones a mostrar
                                    $start = max(1, $paginaActual - floor($maxButtons / 2));
                                    $end = min($start + $maxButtons - 1, $totalBotones);

                                    for ($i = $start; $i <= $end; $i++) :
                                    ?>
                                        <li class="<?php if ($i == $paginaActual) echo 'active'; ?>">
                                            <a href="?page=<?php echo $i; ?>&search="><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>

                                    <?php if ($paginaActual < $totalCategorias) : ?>
                                        <li>
                                            <a href="?page=<?php echo $paginaActual + 1; ?>&search=">
                                                <svg width="10" height="15" viewBox="0 0 10 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M8.8788 7.46543L2.43654 13.8092C2.1795 14.0662 1.76387 14.0662 1.50683 13.8092L1.11856 13.4209C0.861521 13.1639 0.861521 12.7482 1.11856 12.4912L6.7131 7.00059L1.12402 1.50997C0.866998 1.25293 0.866998 0.837303 1.12402 0.580281L1.51231 0.191991C1.76933 -0.0650311 2.18496 -0.0650311 2.442 0.191991L8.88422 6.53574C9.1357 6.79278 9.1357 7.20841 8.8788 7.46543Z" fill="white" fill-opacity="0.5" />
                                                </svg>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>

                        </div>

                        <div class="sidebar">
                            <div class="widget-sidebar category">
                                <h5 class="heading">Categoria (Listas)</h5>
                                <ul>
                                    <?php
                                    // Consulta que obtiene las categorías con id_seccion = '2' y cuenta los videos por categoría
                                    $res = $conexion->query("
        SELECT categorias.id, categorias.nombre, seccion.descrip, categorias.id_seccion, 
               (SELECT COUNT(*) FROM videos WHERE videos.id_categoria = categorias.id) AS video_count
        FROM categorias
        INNER JOIN seccion ON categorias.id_seccion = seccion.id
        WHERE categorias.id_seccion = '2'
    ");

                                    // Muestra los nombres de las categorías y la cantidad de videos en el li
                                    while ($f = mysqli_fetch_array($res)) {
                                        echo '<li><a href="#">' . $f['nombre'] . '  <span>(' . $f['video_count'] . ')</span></a></li>';
                                    }
                                    ?>

                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!-- Lista -->



        <!-- footer -->
        <?php include("./layouts/footer.php"); ?>
        <!-- footer -->
        <a id="scroll-top"><span class="icon-arrow-top"></span></a>

    </div>

    <script src="app/js/jquery.min.js"></script>
    <script src="app/js/jquery.easing.js"></script>
    <script src="app/js/jquery-migrate.min.js"></script>
    <script src="app/js/plugins.js"></script>
    <script src="app/js/countto.js"></script>
    <script src="app/js/wow.min.js"></script>

    <script src="app/js/app.js"></script>
    <script src="app/js/count-down.js"></script>

    <script src="app/js/aos.js"></script>

    <script src="app/js/swiper-bundle.min.js"></script>
    <script src="app/js/swiper.js"></script>

    <!-- Initialize Swiper -->

</body>

</html>