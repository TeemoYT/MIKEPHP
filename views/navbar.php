<?php
require_once __DIR__ . "/../module/module.php";

$collectionModule = new CollectionsModules();
$categories = $collectionModule->getCategory();
$menuTree = [];

foreach ($categories as $category) {
  $menuTree[$category['id']] = [
    'id' => $category['id'],
    'name' => $category['name'],
    'slug' => $category['slug'],
    'parent_id' => $category['parent_id'],
    'children' => []
  ];
}

// Tạo danh sách danh mục cha
$finalMenu = [];

foreach ($menuTree as $id => &$category) {
  if ($category['parent_id'] != 0 && isset($menuTree[$category['parent_id']])) {

    $menuTree[$category['parent_id']]['children'][] = &$category;
  } else {

    $finalMenu[$id] = &$category;
  }
}
unset($category);
$menuTree = $finalMenu;


function renderMenu($categories)
{
  if (empty($categories)) return;
  echo '<ul class="dropdown-menu">';
  foreach ($categories as $category) {
    $hasChildren = !empty($category['children']);

    echo '<li class="dropdown ' . ($hasChildren ? 'dropend' : '') . '">';
    echo '<a class="dropdown-item ' . ($hasChildren ? 'dropdown-toggle' : '') . '" href="/MIKEPHP/collections/' . htmlspecialchars($category['slug']) . '" ' .  '>';
    echo htmlspecialchars($category['name']);
    echo '</a>';


    if ($hasChildren) {

      renderMenu($category['children']);
    }

    echo '</li>';
  }
  echo '</ul>';
}



?>

  <nav class="navbar navbar-expand-lg bg-body-tertiary ">
    <div class="container-fluid">
      <a href="/MIKEPHP/"><img width="80" height="80" src="/MIKEPHP/img/Logo.png"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse justify-content-center navbar-collapse" id="navbarNav">

        <?php if (!empty($menuTree)): ?>
          <?php $firstCategory = reset($menuTree); ?>
          <?php foreach ($menuTree as $parent): ?>
            <div class="dropdown">
              <a  class="main-link <?php echo !empty($parent['children']) ? 'dropdown-toggle' : '' ?>"
                href="/MIKEPHP/collections/<?php echo $parent['slug'] ?>">
                <?php echo htmlspecialchars($parent['name']); ?>
              </a>
              <?php renderMenu($parent['children']); ?>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

      <form class="d-flex form-search-1" role="search">
        <input class="form-control me-2" type="search" placeholder="Tìm kiếm" aria-label="Search">
        <?php if (isset($_SESSION['user_id'])) { ?>
          <span class="me-2">
            <a href="/MIKEPHP/user/account/profile" class="nav-link py-2 px-0 px-lg-2">
              <i class="fa fa-user-o" aria-hidden="true"></i>
            </a>
          </span>
        <?php } else { ?>
          <span class="me-2">
            <a href="/MIKEPHP/login" class="nav-link py-2 px-0 px-lg-2">
              <i class="fa fa-user-o" aria-hidden="true"></i>
            </a>
          </span>
        <?php } ?>
        <span class="me-2">
          <a class="nav-link py-2 px-0 px-lg-2" href="/MIKEPHP/cart">
            <i class="fa fa-cart-plus" aria-hidden="true"></i>
          </a>
        </span>
      </form>
    </div>
  </nav>
<!-- 
  <script>
  function toggleSearch() {
    var searchBox = document.getElementById('searchBox');
    if (searchBox.style.display === "none" || searchBox.style.display === "") {
      searchBox.style.display = "flex";
    } else {
      searchBox.style.display = "none";
    }
  }
</script> -->
