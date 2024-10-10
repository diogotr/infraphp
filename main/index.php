<?php
include('../include/header.php');
$form = 'Contact';
$form_plural = 'Contacts';
?>

<div class="container">
  <div class="row">
    <div class="col-sm pt-4">
      <div class="card border-dark mb-3">
        <div class="card-header">Sistemas ERP</div>
        <div class="card-body text-dark">
          <h5 class="card-title">ERP</h5>
          <p class="card-text">Sistema ERP para pequenas e médias empresas, com controle de estoque, financeiro e emissão de nota fiscais.</p>
        </div>
      </div>
    </div>
    <div class="col-sm pt-4">
      <div class="card border-dark mb-3">
        <div class="card-header">Sistemas Personalizados</div>
        <div class="card-body text-dark">
          <h5 class="card-title">Desenvolvimento WEB e Desktop</h5>
          <p class="card-text">Desenvolvemos seu sistema sob medida, personalizado para a sua empresa e com integração com outros sistemas.</p>
        </div>
      </div>
    </div>
    <div class="col-sm pt-4">
      <div class="card border-dark mb-3">
        <div class="card-header">Artificial Inteligence</div>
        <div class="card-body text-dark">
          <h5 class="card-title">Dark card title</h5>
          <p class="card-text">Some quick example text to build on the card title and make up the bulk of
            the card's content.</p>
        </div>
      </div>
    </div>
    <div class="col-sm pt-4">
      <div class="card border-dark mb-3">
        <div class="card-header">User</div>
        <div class="card-body text-dark">
          <h5 class="card-title"><?= $_SESSION['username'] ?></h5>
          <p class="card-text">Open Tasks: </p>
          <p class="card-text">Contacts: </p>
        </div>
      </div>
    </div>
  </div>
</div>


<?php
include('../include/footer.php');