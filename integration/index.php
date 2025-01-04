<?php
include('../include/header.php');
require_once('../include/functions.php');
$usd_rate = getCotacao('USD-BRL');
$btc_rate = getCotacao('BTC-USD');

?>
<div class="container">
  <div class="row">
    <div class="col">
      <div class="card-deck">
        <div class="card">
          <div class="card-header">API - Exchange Rates</div>
          <div class="card-body">
            <h5 class="card-title">USD-BRL</h5>
            <p class="card-text">$ 1.000 <?= $usd_rate['code'] ?> = R$ <?= number_format($usd_rate['price'], 3, '.', ',') ?> BRL</p>
            <h5 class="card-title">BTC-USD</h5>
            <p class="card-text">$ 1.000 <?= $btc_rate['code'] ?> = $ <?= number_format($btc_rate['price'], 3, '.', ',') ?> USD</p>
          </div>
        </div>
        <div class="card">
          <div class="card-header">Systems for your Company</div>
          <div class="card-body">
            <h5 class="card-title">WEB and Desktop development</h5>
            <p class="card-text">Solutions with the most modern technologies, such as Django, This card has supporting
              text below as a natural lead-in to additional content.</p>
          </div>
        </div>
        <div class="card">
          <div class="card-header">Artificial Inteligence</div>
          <div class="card-body">
            <h5 class="card-title">AI for business</h5>
            <p class="card-text">-Model fine tuning to apply A.I. in your business.<br>
              -Personalized text chats like Chat GPT.<br>
              -With data integration with A.I. you can make reports, charts and analisys.</p>

          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?php
include('../include/footer.php');