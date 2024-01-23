// ARCHIVO JSON
const provinciasJSON = 'assets/json/provincias.json';
const ciudadesJSON = 'assets/json/poblaciones.json';

function cargarProvincias(provinciaSelect) {
  let provinciasData = null;

  function agregarProvincia() {
    provinciasData.forEach(provincia => {
      const optionElement = document.createElement('option');
      optionElement.value = provincia.label;
      optionElement.textContent = provincia.label;
      optionElement.setAttribute('code', provincia.code);
      provinciaSelect.appendChild(optionElement);
    });
  }

  if (provinciasData) {
    agregarProvincia();
  } else {
    fetch(provinciasJSON)
      .then(response => {
        if (!response.ok) {
          throw new Error(`Error al abrir el provinciasJSON: ${response.status}`);
        }
        return response.json();
      })
      .then(data => {
        provinciasData = data.sort((a, b) => a.label.localeCompare(b.label));
        agregarProvincia();
      })
      .catch(error => {
        console.error('Error al leer el provinciasJSON ', error);
      });
  }
}

function cargarCiudades(provinciaSelect, ciudadSelect) {
  const defaultOption = document.createElement('option');
  defaultOption.value = '';
  defaultOption.textContent = 'Seleccionar Ciudad';

  provinciaSelect.addEventListener('change', function () {
    ciudadSelect.innerHTML = '';
    ciudadSelect.appendChild(defaultOption);

    const opcionSeleccionada = provinciaSelect.options[provinciaSelect.selectedIndex];
    const valorCode = opcionSeleccionada.getAttribute('code');

    fetch(ciudadesJSON)
      .then(response => {
        if (!response.ok) {
          throw new Error(`Error en ciudadesJSON: ${response.status}`);
        }
        return response.json();
      })
      .then(data => {
        const ciudadesFiltradas = data.filter(ciudad => ciudad.parent_code === valorCode);

        ciudadesFiltradas.forEach(ciudad => {
          const optionElement = document.createElement('option');
          optionElement.value = ciudad.label;
          optionElement.textContent = ciudad.label;
          ciudadSelect.appendChild(optionElement);
        });
      })
      .catch(error => {
        console.error('Error al leer el ciudadesJSON:', error);
      });
  });
}
