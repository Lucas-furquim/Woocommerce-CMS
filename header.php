<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php bloginfo('name') ?> <?php wp_title('|');  ?></title>
  <?php wp_head(); ?>

</head>
<body <?php body_class(); ?>> 

<?php 

$img_url = get_stylesheet_directory_uri() . '/img';
$cart_count = WC()->cart->get_cart_contents_count();
?>

<header class='header container'>
  <a href="/handel"><img src="<?= $img_url ?>/handel.svg" alt="Handel"></a>

  <div class='busca'>

    <form action="<?php bloginfo("url"); ?>/loja/" method="get">
      
    <input type="text" name="s" id="s" placeholder="Buscar" value="<?php the_search_query(); ?>">
    <input type="text" name='post_type' value='product' class='hidden'>
    <input type="submit" id='searchbutton' value='Buscar'>

    </form>
  </div>

  <nav class='conta'>
    <a href="handel/minha-conta" class='minha-conta'>Minha Conta</a>
    <a href="handel/carrinho" class='carrinho'>Carrinho
      <?php if($cart_count) { ?>

        <span class='carrinho-count'><?= $cart_count; ?></span>

     <?php }; ?>
    </a>
    </nav>
</header>

<?php 
wp_nav_menu([
  'menu' => 'categorias',
  'container' => 'nav',
  'container_class' => 'menu-categorias'
  ])
?>
