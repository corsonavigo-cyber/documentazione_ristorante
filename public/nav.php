<body>
<nav>
  <ul>
   <li class="listamenu home-item">
     <a class="menu home-link<?= empty($_GET['cartella']) || empty($_GET['file']) ? ' menu-attivo' : '' ?>" href="index.php"<?= empty($_GET['cartella']) || empty($_GET['file']) ? ' aria-current="page"' : '' ?>>
       <img src="/documentazione_ristorante/public/asset/img/favicon.png" alt="">
       <strong>Home</strong>
     </a>
   </li>
    <?php leggimenu(); ?>
  </ul>
</nav>