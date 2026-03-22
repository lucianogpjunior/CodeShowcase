<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      
      <div class="nav-section-left">
        <a class="navbar-brand custom-brand" href="#">
          Code<span class="showcase-colorNav">Showcase</span>
        </a>
      </div>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav-content">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="nav-content">
        
        <div class="nav-section-center">
          <b-input-group class="barra-busca-container">
            <b-form-input 
              class="input-escuro" 
              placeholder="O que você está procurando? Digite aqui..."
            ></b-form-input>
            
            <b-input-group-append>
              <b-button class="btn-lupa">
                <b-icon icon="search"></b-icon>
              </b-button>
            </b-input-group-append>
          </b-input-group>
        </div>

        <div class="nav-section-right d-flex align-items-center justify-content-end flex-grow-1">
          <b-button variant="link" class="text-white text-decoration-none me-2">
            Cadastre-se
          </b-button>
          <b-button variant="primary">
            <b-icon icon="cart-fill"></b-icon>
          </b-button>
        </div>
        
      </div>
    </div>
  </nav>
</template>

<script>
</script>

<style scoped>
.custom-brand {
  font-family: 'Arial Narrow', sans-serif;
  font-weight: bold;
  font-size: 1.5rem;
}
.showcase-colorNav {
  color: #5B1166;
}

.nav-section-center {
  display: flex;
  justify-content: center;
  min-width: 300px;
}

.barra-busca-container {
  max-width: 400px; 
  width: 100%;
}

.input-escuro {
  background-color: #333333 !important;
  border: none !important;
  color: #ffffff !important;
  border-radius: 4px 0 0 4px !important;
}

.input-escuro::placeholder {
  color: #888;
}

.btn-lupa {
  border: none !important;
  border-radius: 0 4px 4px 0 !important;
  color: white !important;
}
.custom-brand {
    font-size: 2rem !important;
}

.barra-busca-container {
    max-width: 500px;
    height: 50px;
}

.input-escuro, .btn-lupa {
    height: 100%;
    font-size: 1.1rem;
}

.b-icon {
    font-size: 1.4rem !important;
}
.navbar .container-fluid {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

@media (min-width: 992px) {
  .nav-section-left, .nav-section-right {
    flex-basis: 0; 
  }
}
</style>