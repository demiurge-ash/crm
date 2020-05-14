    Vue.component('autocomplete', {
        template: '<div>' +
            '<input type="text" class="form-control" id="name" name="order-client-name" v-model="searchquery" ' +
                'v-on:keyup="autoComplete" @input="onInput($event.target.value)" @keyup.esc="escaped" ' +
                '@blur="escaped" @keydown.down="moveDown" @keydown.up="moveUp" @keydown.enter="select">' +
            '<div class="autocomplete-wrapper" v-if="data_results.length">' +
            '<ul class="list-group"  v-show="isOpen">' +
            '<li class="list-group-item cursor-pointer" v-for="(result, index) in data_results" :class="{\'highlighted\': index === highlightedPosition} " ' +
                '@mouseenter="highlightedPosition = index" @mousedown="select" ' +
                ':title="result.name" :description="result.description" :phone="result.phone" :email="result.email">' +
            '{{ result.name }}' +
            '</li>' +
            '</ul>' +
            '</div>' +
            '</div>'
        ,
        data: function () {
            return {
                searchquery: '',
                data_results: [],
                raw_data: [],
                isOpen: false,
                highlightedPosition: 0,
            }
        },
        methods: {
            autoComplete(){
                if(this.searchquery.length > 1){
                    axios.get('/search/client',{params: {q: this.searchquery}}).then(response => {
                        this.data_results = response.data;
                    });
                }else{
                    this.data_results = [];
                }
            },
            onInput(value) {
                this.highlightedPosition = 0
                this.isOpen = !!value
            },
            moveDown() {
                if (!this.isOpen) {
                    return
                }
                this.highlightedPosition =
                    (this.highlightedPosition + 1) % this.data_results.length
            },
            moveUp() {
                if (!this.isOpen) {
                    return
                }
                this.highlightedPosition = this.highlightedPosition - 1 < 0 ? this.data_results.length - 1 : this.highlightedPosition - 1
            },
            escaped() {
                this.data_results = [];
                this.isOpen = false
            },
            select() {
                const selectedOption = this.data_results[this.highlightedPosition]
                this.$emit('select', selectedOption)
                this.escaped()
                this.searchquery = selectedOption.name

                this.$bus.$emit('orderClientPhone', selectedOption.phone);
                this.$bus.$emit('orderClientEmail', selectedOption.email);

                $('#client-description').attr('data-original-title', selectedOption.description)

                $('#name').blur();
            },
        },
    });