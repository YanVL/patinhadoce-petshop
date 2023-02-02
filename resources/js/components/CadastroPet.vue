<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header background-1 text-black-50">Cadastre seu Pet</div>

                    <div class="card-body background-2">
                        <form action="{{ route('pets') }}" method="post">
                            <div class="row mb-3">
                                <label for="nome" class="col-md-4 col-form-label text-md-end">Nome do Pet</label>

                                <div class="col-md-6">
                                    <input id="nome" type="text" class="form-control" name="nome" required
                                        autocomplete="nome" autofocus v-model="nome">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="especie" class="col-md-4 col-form-label text-md-end">Espécie (Cachorro,
                                    gato...)</label>

                                <div class="col-md-6">
                                    <input id="especie" type="text" class="form-control" name="especie" required
                                        autocomplete="current-especie" v-model="especie">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="observacao" class="col-md-4 col-form-label text-md-end">Observação
                                    (Opcional)</label>

                                <div class="col-md-6">
                                    <input id="observacao" type="text" class="form-control" name="observacao" required
                                        autocomplete="current-observacao" v-model="observacao">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-1">
                                        Cadastrar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
   
}
</script>
