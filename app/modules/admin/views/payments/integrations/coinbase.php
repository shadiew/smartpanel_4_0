<?php
  $payment_elements = [
    [
      'label'      => form_label('API key'),
      'element'    => form_input(['name' => "payment_params[option][api_key]", 'value' => @$payment_option->api_key, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Webhook key'),
      'element'    => form_input(['name' => "payment_params[option][webhook_key]", 'value' => @$payment_option->webhook_key, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
  ];
  echo render_elements_form($payment_elements);
?>

<div class="form-group">
  <label class="form-label">Config:</label>
  <div class="description-content">
    <ol class="small">
      <li>Sign in or create an <a href="https://commerce.coinbase.com/" target="_blank">account</a></li>
      <li>Settings → API keys
        <ul>
          <li>Generate API key by press <strong>Create an API key</strong> button</li>
          <li>Copy generated <strong>API key</strong> and paste here </li>
        </ul>
      </li>
      <li>Settings → Webhook subscriptions → Add an endpoint
        <ul>
          <li>Fill <strong>New Webhook Subscription</strong> by <code><?php echo cn('coinbase_ipn'); ?></code></li>
        </ul>
      </li>
      <li>Settings → Webhook subscriptions → Show shared secret
        <ul>
            <li>Copy <strong>Webhook Shared Secret</strong> and paste here as <strong>Webhook Key</strong></li>
        </ul>
      </li>
      <li>Settings → Webhook subscriptions → Details → Events → Edit</li>
      <li>Switch on the following events:
        <ol>
          <li><strong>charge:created</strong></li>
          <li><strong>charge:confirmed</strong></li>
          <li><strong>charge:delayed</strong></li>
          <li><strong>charge:pending</strong></li>
          <li><strong>charge:resolved</strong></li>
        </ol>
      </li>
    </ol>
  </div>
</div>
