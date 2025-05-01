<?php 

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

function salvar_presente_checkout($order_id) {
  if (isset($_POST['billing_presente'])) {
    update_post_meta($order_id, '_billing_presente', sanitize_text_field($_POST['billing_presente']));
  }
}
add_action('woocommerce_checkout_update_order_meta', 'salvar_presente_checkout');

function show_admin_custom_checkout_presente($order) {
  $presente = get_post_meta($order->get_id(), '_billing_presente', true);
  echo '<p><strong>Presente:</strong> ' . esc_html($presente) . '</p>';
}
add_action('woocommerce_admin_order_data_after_shipping_address', 'show_admin_custom_checkout_presente');
