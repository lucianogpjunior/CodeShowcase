<template>
    <footer class="custom-footer">
  <div class="container py-5">
    <div class="row">
      <div class="col-lg-4 col-md-6 mb-4">
        <h5 class="footer-brand">Code<span>Showcase</span></h5>
        <p class="text-muted">Texto...</p>

        <div class="social-icons">
          <b-icon icon="github" class="me-3"></b-icon>
          <b-icon icon="linkedin" class="me-3"></b-icon>
          <b-icon icon="instagram"></b-icon>
        </div>
      </div>

      <div class="col-lg-4 col-md-6 mb-4 d-flex justify-content-lg-center">
        <div>
          <h6 class="text-uppercase fw-bold mb-3">Links Rápidos</h6>
          <ul class="list-unstyled">
            <li><a href="#" class="footer-link">Início</a></li>
            <li><a href="#" class="footer-link">Explorar Projetos</a></li>
            <li><a href="#" class="footer-link">Planos Pro</a></li>
            <li><a href="#" class="footer-link">FAQ</a></li>
          </ul>
        </div>
      </div>

      <div class="col-lg-4 col-md-12">
        <h6 class="text-uppercase fw-bold mb-3">Fique por dentro</h6>
        <p class="text-muted">Receba as novidades e novos templates.</p>
        <div class="input-group mb-3 shadow-sm">
          <input type="text" class="form-control input-newsletter" placeholder="Seu e-mail">
          <button class="btn btn-purple" type="button">Assinar</button>
        </div>
      </div>
    </div>
  </div>

  <div class="footer-bottom text-center py-3">
    <small>&copy; 2026 CodeShowcase - Todos os direitos reservados.</small>
  </div>
</footer>
</template>

<script>
</script>

<style scoped>
.custom-footer {
  background-color: black;
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  position: relative;
}

.main-content {
  padding-bottom: 60px; 
}
</style>