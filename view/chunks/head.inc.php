<?
function html_headChunk($title)  {
    $randomVersion = rand(10, 9999);
    $site = new Site();
    echo "
    <head >
      <meta charset = 'utf-8'>
      <title>{$site->sitename} — {$site->description}</title >
      <meta name='description' content='{$_SESSION['description']}'>
      <meta name = 'viewport' content = 'width=device-width, initial-scale=1, maximum-scale=1'>
      <meta property='og:image' content='/images/social-cover.png'>
      <link rel = 'stylesheet' href = '/styles/style.css?{$randomVersion}'>
      <link rel = 'stylesheet' href = '/styles/font-awesome/fontawesome.min.css'>
      <link rel = 'stylesheet' href = '/styles/font-awesome/regular.min.css'>
      <link rel = 'stylesheet' href = '/styles/font-awesome/solid.min.css'>
      <link rel = 'stylesheet' href = '/styles/font-awesome/light.min.css'>
      <link rel = 'stylesheet' href = '/styles/font-awesome/brands.min.css'>
      <script src = '/scripts/jquery-3.4.1.min.js'></script>
      <script src = '/scripts/app.min.js?{$randomVersion}'></script>
    </head >";
}
?>


