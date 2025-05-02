<?php 

// Remove telefone e adiciona campo de presente
function handel_checkout_custom($fields) {
  unset($fields['billing']['billing_phone']);

  $fields['billing']['billing_presente'] = [
    'label' => 'Embrulhar para presente?',
    'required' => false,
    'class' => ['form-row-wide'],
    'clear' => true,
    'type' => 'select',
    'options' => [
      'nao' => 'Não',
      'sim' => 'Sim'
    ]
  ];

  return $fields;
}
add_filter('woocommerce_checkout_fields', 'handel_checkout_custom');

// Salva campo "presente"
function salvar_presente_checkout($order_id) {
  if (isset($_POST['billing_presente'])) {
    update_post_meta($order_id, '_billing_presente', sanitize_text_field($_POST['billing_presente']));
  }
}
add_action('woocommerce_checkout_update_order_meta', 'salvar_presente_checkout');

// Exibe campo de mensagem no checkout
function handel_custom_checkout_field($checkout) {
  woocommerce_form_field('mensagem_personalizada', [
    'type' => 'textarea',
    'class' => ['form-row-wide mensagem-personalizada'],
    'label' => 'Mensagem Personalizada',
    'placeholder' => 'Escreva uma mensagem para a pessoa que você está presentando.',
    'required' => true,
  ], $checkout->get_value('mensagem_personalizada'));
}
add_action('woocommerce_after_order_notes', 'handel_custom_checkout_field');

// Valida campo
function handel_custom_checkout_field_process() {
  if (!isset($_POST['mensagem_personalizada']) || empty(trim($_POST['mensagem_personalizada']))) {
    wc_add_notice('Por favor, escreva algo na mensagem personalizada.', 'error');
  }
}
add_action('woocommerce_checkout_process', 'handel_custom_checkout_field_process');

// Salva campo no pedido
function handel_checkout_update($order_id) {
  if (isset($_POST['mensagem_personalizada'])) {
    update_post_meta($order_id, 'mensagem_personalizada', sanitize_text_field($_POST['mensagem_personalizada']));
  }
}
add_action('woocommerce_checkout_update_order_meta', 'handel_checkout_update');

// Exibe no admin do pedido
function show_admin_custom_checkout_presente($order) {
  $presente = get_post_meta($order->get_id(), '_billing_presente', true);
  $mensagem = get_post_meta($order->get_id(), 'mensagem_personalizada', true);
  echo '<p><strong>Presente:</strong> ' . esc_html($presente) . '</p>';
  echo '<p><strong>Mensagem:</strong> ' . nl2br(esc_html($mensagem)) . '</p>';
}
add_action('woocommerce_admin_order_data_after_shipping_address', 'show_admin_custom_checkout_presente');
