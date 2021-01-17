<?php

require_once 'class/Message.php';
require_once 'class/GuestBook.php';

$success = false;
$errors = null;
$guestbook = new GuestBook(__DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'messages');

if (isset($_POST['username'], $_POST['message']))
{
  $message = new Message($_POST['username'], $_POST['message']);

  if ($message->isValid())
  {
    $guestbook->addMessage($message);
    $success = true;
    $_POST = [];
  } else $errors = $message->getErrors();

}

$title = "Livre d'or";
$messages = $guestbook->getMessages();
require 'elements/header.php';

?>

<div class="container">
  <h1>Livre d'or</h1>

  <?php if (!empty($success)): ?><div class="alert alert-success">Merci pour votre message !</div><?php endif;
        if (!empty($errors)): ?><div class="alert alert-danger">Formulaire invalide</div><?php endif ?>

  <form method="post">
    <div class="form-group">
      <input type="text" name="username" placeholder="Votre pseudo" value="<?= htmlentities($_POST['username'] ?? '') ?>" class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>">
      <?php if (isset($errors['username'])): ?><div class="invalid-feedback"><?= $errors['username'] ?></div><?php endif ?>
    </div>
    <div class="form-group">
      <textarea name="message" placeholder="Votre message" class="form-control <?= isset($errors['message']) ? 'is-invalid' : '' ?>"><?= htmlentities($_POST['message'] ?? '') ?></textarea>
      <?php if (isset($errors['message'])): ?><div class="invalid-feedback"><?= $errors['message'] ?></div><?php endif ?>
    </div>
    <button class="btn btn-primary">Envoyer</button>
  </form>

  <?php if (!empty($messages)): ?>

  <h2 class="mt-4">Vos messages</h2>

  <?php

  foreach ($messages as $message) echo $message->toHTML();

  endif;

  ?>

</div>

<?php require 'elements/footer.php';
