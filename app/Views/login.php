<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>SCADA POS</title>
    <link rel="icon" type="image/x-icon" href="/dist/img/favicon.ico" />
    <!-- CSS files -->
    <link href="<?=base_url('dist/css/tabler.min.css?1684106062');?>" rel="stylesheet"/>
    <link href="<?=base_url('dist/css/tabler-flags.min.css?1684106062');?>" rel="stylesheet"/>
    <link href="<?=base_url('dist/css/tabler-payments.min.css?1684106062');?>" rel="stylesheet"/>
    <link href="<?=base_url('dist/css/tabler-vendors.min.css?1684106062');?>" rel="stylesheet"/>
    <link href="<?=base_url('dist/css/demo.min.css?1684106062');?>" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
  </head>
  <body  class=" d-flex flex-column">
    <script src="<?=base_url('dist/js/demo-theme.min.js?1684106062');?>"></script>
    <div class="page page-center">
      <div class="container container-tight py-4">
        <div class="text-center mb-4">
          <a href="#" class="navbar-brand navbar-brand-autodark"><img src="<?=base_url('dist/img/favicon.ico');?>" height="27" alt="">SCADA POS</a>
        </div>
        <div class="card card-md">
          <div class="card-body">
            <h2 class="h2 text-center mb-4">Login to your account</h2>
            <form action="<?=site_url('login');?>" method="post" autocomplete="off" novalidate>
              <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" class="form-control" placeholder="your@email.com" autocomplete="off" name="email">
              </div>
              <div class="mb-2">
                <label class="form-label">
                  Password
                </label>
                <div class="input-group input-group-flat">
                  <input type="password" class="form-control"  placeholder="Your password" name="password" autocomplete="off">
                </div>
              </div>
              <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">Sign in</button>
              </div>
            </form>
                                <p><?=session()->getFlashData('pesan');?></p>
          </div>
        </div>
      </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="<?=base_url('dist/js/tabler.min.js?1684106062');?>" defer></script>
    <script src="<?=base_url('dist/js/demo.min.js?1684106062');?>" defer></script>
  </body>
</html>