<script>
document.addEventListener('DOMContentLoaded', function () {
    const countrySelect = document.getElementById('country_id');
    const stateSelect = document.getElementById('state_id');
    const citySelect = document.getElementById('city_id');

    const statesUrl = "{{ route('ajax.states', ':country') }}";
    const citiesUrl = "{{ route('ajax.cities', ':state') }}";

    // Country change -> States load karo
    countrySelect.addEventListener('change', function () {
        stateSelect.innerHTML = '<option value="">Select State</option>';
        citySelect.innerHTML = '<option value="">Select City</option>';

        if (!this.value) return;

        fetch(statesUrl.replace(':country', this.value))
            .then(res => res.json())
            .then(states => {
                states.forEach(s => stateSelect.add(new Option(s.name, s.id)));
            });
    });

    // State change -> Cities load karo
    stateSelect.addEventListener('change', function () {
        citySelect.innerHTML = '<option value="">Select City</option>';

        if (!this.value) return;

        fetch(citiesUrl.replace(':state', this.value))
            .then(res => res.json())
            .then(cities => {
                cities.forEach(c => citySelect.add(new Option(c.name, c.id)));
            });
    });
});
</script>