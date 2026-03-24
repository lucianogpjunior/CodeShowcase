<template>
  <div>
    <header><p style="text-align: center;">*A fazer troca de modo claro/escuro*</p></header>
  <!--NavBar abaixo-->
    <nav class="navbar navbar-expand-lg navbar-dark custom-navbar">
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
          
          <div class="nav-section-center mx-auto">
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

          <div class="nav-section-right d-flex align-items-center justify-content-end">
            <b-button variant="link" class="text-white text-decoration-none me-2">
              Log-in
            </b-button>

            <b-button variant="primary">
              <b-icon icon="cart-fill"></b-icon>
            </b-button>
          </div>
          
        </div>
      </div>
    </nav>
  </div>  
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
  color: #9c1faf;
}

.nav-section-center {
  display: flex;
  justify-content: center;
  min-width: 300px;
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
  max-width: 600px;
  height: 39px;
}

.input-escuro, .btn-lupa {
  height: 35px;
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
.custom-navbar {
  background-color: #170229 !important; 
  height: 65px;
  display: flex;
  align-items: center;
}
header {
  background-color: rgb(51, 23, 97);
  height: 28px;
}
p {
  color: white;
}

@media (min-width: 992px) {
.nav-section-left, .nav-section-right {
  flex-basis: 0 auto;
  display: flex;
  justify-content: flex-end;
  padding-right: 200px; 
}
.nav-section-left {
  flex: 1;
  display: flex;
  justify-content: flex-end;
  padding-right: px; 
}

.nav-section-right {
  flex: 1;
  }
.nav-section-center{
  flex: 1;
  }
}
</style>