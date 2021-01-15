<?php
  $pageTitle = 'Submit Request for Appointment';
  require 'includes/header.php';
  
  if (!isAuthenticated()) {
    header("Location: login.php?no-access=1");
  }

  $errors = [];
  $f['title'] = trim($_POST['title'] ?? '');
  $f['category'] = $_POST['cat'] ?? 0;
  $f['poem'] = trim($_POST['poem'] ?? '');

  $qCategories = "SELECT c.category_id, c.category
    FROM categories c
    LEFT JOIN poems p ON c.category_id = p.category_id
    GROUP BY c.category_id
    ORDER BY c.category";

  try {
    $stmtCats = $db->prepare($qCategories);
    $stmtCats->execute();
  } catch (PDOException $e) {
    logError($e);
    $errors[] = 'Oops. Our bad. Cannot get categories.';
  }

  if (!empty($_POST['submit'])) {
    // Validate Form Entries
    if (!$f['title']) {
      $errors[] = 'You must enter a poem title.';
    }
    if (!$f['category']) {
      $errors[] = 'You must select a category.';
    }
    if (!$f['poem'] || strlen($f['poem']) < 10) {
      $errors[] = 'Your poem must be at least 10 characters.';
    }

    // if (!$errors) {
    //   // Insert poem
    //   $dateApproved = 'null'; // For now

    //   $qInsert = "INSERT INTO poems
    //   (title, poem, category_id, user_id, date_approved)
    //   VALUES (:title, :poem, :category_id, :user_id,
    //           $dateApproved);";

    //   try {
    //     $stmtInsert = $db->prepare($qInsert);
    //     $stmtInsert->bindParam(':title', $f['title']);
    //     $stmtInsert->bindParam(':poem', $f['poem']);
    //     $stmtInsert->bindParam(':category_id', $f['category']);
    //     $stmtInsert->bindParam(':user_id', $currentUserId);
    //     $stmtInsert->execute();

    //     $lastInsertId = $db->lastInsertId();
    //     header("Location: poem.php?poem-id=$lastInsertId");
    //   } catch (PDOException $e) {
    //     logError($e);
    //     $errors[] = 'Oops. Our bad. Cannot insert poem.';
    //   }
    // }
  }
?>
<main id="poem-submit">
  <h1><?= $pageTitle ?></h1>
  <?php 
    if ($errors) {
      echo '<h3>Please correct the following errors:</h3>
      <ol class="error">';
      foreach ($errors as $error) {
        echo "<li>$error</li>";
      }
      echo '</ol>';
    }
  ?>
  <form method="post" action="poem-submit.php" novalidate>
    <label for="title">Title*:</label>
    <input name="title" id="title"
      value="<?= $f['title'] ?>" required>
    <label for="cat">Category:</label>
    <select name="cat" id="cat">
      <option value="0">--Choose a Category</option>
      <?php
        while ($row = $stmtCats->fetch()) {
          $category = $row['category'];
          $categoryId = $row['category_id'];
          $selected = $categoryId === $f['category'] ?
            ' selected' : '';
          echo "<option value='$categoryId'$selected>
            $category
          </option>";
        }
      ?>
    </select>
    <label for="poem">Poem*:</label>
    <textarea id="poem" name="poem"><?= $f['poem'] ?></textarea>
    <button name="submit" value="1" class="wide">Submit Poem</button>
  </form>
</main>
<?php
  require 'includes/footer.php';
?>