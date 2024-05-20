<?php
// Set variables for our request
$shop = 'optimal-essentials-dev';

$api_key = "6369346318e779a5ece0b92a8d9063c0";
$scopes = "read_orders,read_assigned_fulfillment_orders, write_checkouts, read_checkouts, read_content, write_content, read_customers, write_customers, read_products, write_products, read_product_listings, write_discounts,write_files, read_inventory,write_inventory,read_legal_policies,read_locales,write_locales,read_locations,read_marketing_events,write_marketing_events,read_merchant_managed_fulfillment_orders,write_merchant_managed_fulfillment_orders,write_orders,read_payment_terms,write_payment_terms,read_price_rules,write_price_rules,read_product_listings,read_purchase_options,write_purchase_options,read_reports,write_reports,read_resource_feedbacks,write_resource_feedbacks,read_script_tags,write_script_tags,read_shipping,write_shipping,read_shopify_payments_disputes,read_shopify_payments_payouts,read_returns,write_returns,read_themes,write_themes,read_translations,write_translations,read_third_party_fulfillment_orders,read_order_edits,write_order_edits,read_draft_orders,write_draft_orders,read_order_edits,write_order_edits,read_checkouts,write_checkouts,read_draft_orders,write_draft_orders";
$redirect_uri = "https://app.optimalessentials.com.au/optimalessentials/token.php";


// Build install/approval URL to redirect topa
$install_url = "https://" . $shop . ".myshopify.com/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);

echo $install_url;

// Redirect
header("Location: " . $install_url);
die();
?>