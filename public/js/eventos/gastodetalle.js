
    var ComunidadId = 1;
    var loadingEl = document.createElement("div");

    function bloquear(){
        document.body.prepend(loadingEl);
        loadingEl.classList.add("page-loader");
        loadingEl.classList.add("flex-column");
        loadingEl.classList.add("bg-dark");
        loadingEl.classList.add("bg-opacity-25");
        loadingEl.innerHTML = `<span class="spinner-border text-primary" role="status"></span>
                               <span class="text-gray-800 fs-6 fw-semibold mt-5">Cargando...</span>`;

    }
    $('.select-1').select2();
    //$("#NuevoGasto").tooltip();

    $("#AgregarGasto").click( function (e) {
        e.preventDefault();
        e.stopPropagation();    
        console.log("Agregar Gasto a la lista")
        
    });
