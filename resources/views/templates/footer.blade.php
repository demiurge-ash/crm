<script src="/js/bootstrap.min.js"></script>
<script src="/js/moment-with-locales.js"></script>
<script src="/js/bootstrap-datetimepicker.min.js"></script>
<script src="/js/SimpleTableCellEditor.js"></script>

<script src="/js/component/restrict.vue"></script>

<script>

    $(function () {

        $('#name1').on('input', function (e) {
            var client = $(this).val();
            if (client) {
                var phone = $('#clients [value="' + client + '"]').data('phone');
                if (phone) $('#order-client-phone').val(phone);
                var email = $('#clients [value="' + client + '"]').data('email');
                if (email) $('#order-client-email').val(email);
            }
        })

        $('.datetimepicker').datetimepicker({
            locale: 'ru',
            useCurrent: true,
            format: 'DD.MM.YYYY',
        });
        $(document).on("mouseover", ".datetimepicker", function(){
            $(this).datetimepicker({
                locale: 'ru',
                useCurrent: true,
                format: 'DD.MM.YYYY'
            });
        });
        $('[data-toggle="tooltip"]').tooltip();
        $("[data-toggle=test]").tooltip({
            placement: $(this).data("placement") || 'top'
        });
        moment.locale('ru');
        dateNow = moment().format('L');
        $('.date-now').val(dateNow);

    });

    function setDateNow(id){
        dateNow = moment().format('L');
        $(id).val(dateNow);
    };

    function getDateNow(){
        dateNow = moment().format('L');
        return dateNow;
    };

    function getDateStandartNow(){
        dateNow = moment().format("YYYY-MM-DD");
        return dateNow;
    };

    function getDateStandartPlusMonth(){
        dateAddMonth = moment().add(31, 'days').format("YYYY-MM-DD");
        return dateAddMonth;
    };

    function clearField(id) {
        $(id).val('');
    }

    var button = document.getElementById("copy-materials"),
        input =  document.getElementById("materials");

    if (button) {
        button.addEventListener("click", function(event) {
            event.preventDefault();
            input.select();
            document.execCommand("copy");
        });
    }

    function printTextArea() {
        childWindow = window.open('','childWindow','location=yes, menubar=yes, toolbar=yes');
        childWindow.document.open();
        childWindow.document.write('<html><head></head><body>');
        childWindow.document.write(document.getElementById('task').value.replace(/\n/gi,'<br>'));
        childWindow.document.write('</body></html>');
        childWindow.print();
        childWindow.document.close();
        childWindow.close();
    }
    function printTextAreaRadio() {
        childWindow = window.open('','childWindow','location=yes, menubar=yes, toolbar=yes');
        childWindow.document.open();
        childWindow.document.write('<html><head></head><body>');
        childWindow.document.write(document.getElementById('radiotext').value.replace(/\n/gi,'<br>'));
        childWindow.document.write('</body></html>');
        childWindow.print();
        childWindow.document.close();
        childWindow.close();
    }

    Vue.component('montage', {
        template:'#montage-template',
        data: function(){
            return {
                checked: false,
                hide: false,
                visual_montage: [],
                count: 1,
                montage_count: 0,

                @if( ! empty($current->orderType) && $current->orderType == 'visual-montage')
                current: [
                        @foreach($current->surfaces as $surface)
                    {
                        @foreach($surfaceModelsMontage as $model)
                        '{{$model}}': '{{ $surface->$model ?? '' }}',
                        @endforeach
                    },
                    @endforeach
                ]
                @endif

            }
        },
        methods:{
            addRow:function() {
                this.visual_montage.push({
                    montage_type: 0,
                    quantity: 0,
                    price: 0,
                    sale: 0,
                    total_price: 0,
                    paid: 0,
                    confirmed: 0,
                    manager: 0,
                    name: '',
                    place: '',
                    date_begin: getDateStandartNow(),
                    date_end: getDateStandartPlusMonth(),
                    count: this.count,
                    visual_montage_date_begin: 'visual-montage-date-begin-' + this.count,
                    visual_montage_date_end: 'visual-montage-date-end-' + this.count,
                    visual_montage_location: 'visual-montage-name-' + this.count,
                    visual_montage_vendor: 'visual-montage-place-' + this.count,
                    visual_montage_quantity: 'visual-montage-quantity-' + this.count,
                    visual_montage_price: 'visual-montage-price-' + this.count,
                    visual_montage_sale: 'visual-montage-sale-' + this.count,
                    visual_montage_total_price: 'visual-montage-total-price-' + this.count,
                    visual_montage_paid: 'visual-montage-paid-' + this.count,
                    visual_montage_type: 'visual-montage-type-' + this.count,
                    visual_montage_name: 'visual-montage-name-' + this.count,
                    visual_montage_place: 'visual-montage-place-' + this.count,
                    visual_montage_manager: 'visual-montage-manager-' + this.count,
                    visual_montage_confirmed: 'visual-montage-confirmed-' + this.count,
                    surface_number: 'montage-number-' + this.count,
                })
                this.addValuesToRow(this.count - 1);
                this.count++
            },
            addValuesToRow(surfaceID) {
                @if( ! empty($current->orderType) && $current->orderType == 'visual-montage')
                // restore values of surfaces for editing. vue-style
                if (this.current[surfaceID]) {
                    var surface = this.visual_montage[surfaceID];
                    var restored = this.current[surfaceID];

                    @foreach($surfaceModelsMontage as $model)
                        surface.{{ $model }} = restored.{{ $model }};
                    @endforeach

                        this.cost(surfaceID);
                }
                @endif
            },
            deleteRow(index) {
                this.visual_montage.splice(index,1)
            },
            cost(index) {
                price = this.visual_montage[index].price;
                quantity = this.visual_montage[index].quantity;
                sale = this.visual_montage[index].sale;
                cost = (price * quantity);
                this.visual_montage[index].total_price = (cost - ( cost * sale / 100 )).toFixed(2);

                summ = 0;
                for (var i = 0; i < this.visual_montage.length; i++) {
                    summ += parseFloat(this.visual_montage[i].total_price);
                }
                this.montage_count = summ.toFixed(2);
                this.$bus.$emit('montageCount', this.montage_count);
            },
        },
    });

    Vue.component('placement', {
        template:'#placement-template',
        data: function(){
            return {
                checked:false,
                hide:false,
                visual_placement: [],
                count: 1,
                placement_count: 0,

        @if( ! empty($current->orderType) && $current->orderType == 'visual-placement')
        current: [
        @foreach($current->surfaces as $surface)
            {
            @foreach($surfaceModelsPlacement as $model)
            '{{$model}}': '{{ $surface->$model ?? '' }}',
            @endforeach
            },
        @endforeach
                ]
        @endif

            }
        },
        methods:{
            addRow:function() {
                this.visual_placement.push({
                    quantity: 0,
                    price: 0,
                    cost: 0,
                    sale: 0,
                    total_price: 0,
                    paid: 0,
                    location: '',
                    adv_place: '',
                    date_begin: getDateStandartNow(),
                    date_end: getDateStandartPlusMonth(),
                    count: this.count,
                    visual_placement_date_begin: 'visual-placement-date-begin-' + this.count,
                    visual_placement_date_end: 'visual-placement-date-end-' + this.count,
                    visual_placement_location: 'visual-placement-location-' + this.count,
                    visual_placement_vendor: 'visual-placement-vendor-' + this.count,
                    visual_placement_quantity: 'visual-placement-quantity-' + this.count,
                    visual_placement_price: 'visual-placement-price-' + this.count,
                    visual_placement_cost: 'visual-placement-cost-' + this.count,
                    visual_placement_sale: 'visual-placement-sale-' + this.count,
                    visual_placement_total_price: 'visual-placement-total-price-' + this.count,
                    visual_placement_paid: 'visual-placement-paid-' + this.count,
                    surface_number: 'surface-number-' + this.count,
                })
                this.addValuesToRow(this.count - 1);
                this.count++
            },
            addValuesToRow(surfaceID) {
                @if( ! empty($current->orderType) && $current->orderType == 'visual-placement')
                // restore values of surfaces for editing. vue-style
                if (this.current[surfaceID]) {
                    var surface = this.visual_placement[surfaceID];
                    var restored = this.current[surfaceID];

                @foreach($surfaceModelsPlacement as $model)
                    surface.{{ $model }} = restored.{{ $model }};
                @endforeach

                    this.cost(surfaceID);
                }
                @endif
            },
            deleteRow(index) {
                this.visual_placement.splice(index,1)
            },
            vendor(index) {
                vendorID = this.visual_placement[index].visual_placement_vendor;
                vendorLocation = $("#"+vendorID).find(':selected').attr("data-location");
                this.visual_placement[index].location = vendorLocation;
            },
            cost(index) {
                price = this.visual_placement[index].price;
                quantity = this.visual_placement[index].quantity;
                sale = this.visual_placement[index].sale;
                cost = (price * quantity);
                this.visual_placement[index].total_price = (cost - ( cost * sale / 100 )).toFixed(2);
                this.visual_placement[index].cost = cost;

                summ = 0;
                for (var i = 0; i < this.visual_placement.length; i++) {
                    summ += parseFloat(this.visual_placement[i].total_price);
                }
                this.placement_count = summ.toFixed(2);
                this.$bus.$emit('placementCount', this.placement_count);
            },
        },
    });

    // global bus for parents and components
    Vue.prototype.$bus = new Vue();

    var appOrder = new Vue({
        el: '#orderform',
        data: {

            order_manager: 0,
            order_shop: '',
            order_color: '',
            order_client_raw: '',
            order_pavilion_raw: 0,
            order_building: {!! $buildings !!},
            order_pavilions_raw: [],
            order_pavilions: [],
            order_floor_pavilion_raw: 0,
            order_floor_pavilions: [{"id":0,"name":"—"}], //[{"id":1,"name":"1 этаж"},{"id":2,"name":"2 этаж"},{"id":3,"name":"3 этаж"}],
            selectedBuilding: 0,
            order_type: 1,

            visual_height: 0,
            visual_width: 0,

            radio_price: 0,
            radio_sale: 0,

            visual_designer: 0,

            visual_bypass_type: 'entry',
            visual_pavilion_before: 0,
            visual_pavilion_after: 0,

            visual_design_total_price: 0,

            visual_production_contractor: 0,
            visual_production_quantity: 0,
            visual_production_price: 0,
            visual_production_sale: 0,

            visual_placement_quantity: 0,
            visual_placement_price: 0,
            visual_placement_sale: 0,

            visual_montage_quantity: 0,
            visual_montage_price: 0,
            visual_montage_sale: 0,

            visual_design_side: 0,
            visual_design_direction: 0,

            promo_cost_payment: 0,
            photo_cost_payment: 0,

            searchquery: '',
            order_client_phone: '+7',
            order_client_email: '',

            childPlacementCount: 0,
            childMontageCount: 0,
            visual_product_raw: 1,

            input: 0,

            editModeFirstView: false,

        },
{{--
        created() {
            this.getBuildings();
        },
--}}
        watch: {
            selectedBuilding: function(value) {
                this.getPavilions();
            },
        },
        mounted() {
            this.$bus.$on('placementCount', (value) => {
                this.childPlacementCount = value;
            });
            this.$bus.$on('montageCount', (value) => {
                this.childMontageCount = value;
            });
            this.$bus.$on('orderClientPhone', (value) => {
                this.order_client_phone = value;
            });
            this.$bus.$on('orderClientEmail', (value) => {
                this.order_client_email = value;
            });
        },
        methods: {
            setDateNow: function(id) {
                dateNow = moment().format('L');
                $(id).val(dateNow);
            },
            clearField: function(id) {
                $(id).val('');
            },
            getBuildings() {
                axios.get("/buildings")
                    .then((response) => {
                        this.order_building = response.data;
                    })
            },
            getPavilions() {
                axios.get("/buildings/" + this.selectedBuilding)
                    .then((response) => {
                        this.order_pavilions = response.data;
                        this.order_pavilions_raw = this.order_pavilions;

                        if (this.order_pavilions[0]) {
                            this.order_floor_pavilions = this.getLevels(this.order_pavilions);
                            if (this.editModeFirstView) {
                               this. editModeFirstView = false;
                            }else{
                                var floor = this.order_pavilions[0]['floor'];
                                this.order_floor_pavilion = floor;
                            }
                        } else {
                            this.order_floor_pavilions = [{ "id":0,"name":"—" }];
                            this.order_floor_pavilion = 0;
                        }
                    })
            },
            getLevels(array) {
                var floors = [];
                for (var i = 0; i < array.length; i++) {
                    floors.push(array[i]['floor']);
                }
                floors = this.removeDuplicates(floors);
                var floorsWithNames = [];
                floors.forEach(element => floorsWithNames.push({ "id":element, "name":element + " этаж" }));
                return floorsWithNames;
            },
            removeDuplicates(array) {
                return array.filter(function(element, index, self) {
                    return index === self.indexOf(element);
                });
            },
        },
        computed: {
            visual_product: {
                get () {
                    return this.visual_product_raw;
                },
                set (optionValue) {

                    text = $('#visual-product-'+optionValue).attr('data-specification');
                    $('#materials').val(text);

                    this.visual_product_raw = optionValue;

                    productName = $('#visual-product-'+optionValue).attr('data-type');
                    $('.production-duplicate').val(productName);

                },
            },
            order_client_name: {
                get () {
                    return this.order_client_raw;
                },
                set (optionValue) {
                    this.order_client_raw = optionValue;
                    clientID = $('#clients option[value="' + optionValue + '"]');
                    if (clientID) {
                        phone = clientID.attr('data-phone');
                        if (phone) this.order_client_phone = phone;
                        email = clientID.attr('data-email');
                        if (email) this.order_client_email = email;
                    }
                }
            },
            order_pavilion: {
                get () {
                    return this.order_pavilion_raw;
                },
                set (optionValue) {
                    this.order_pavilion_raw = optionValue;
                    pavilion = $('#order-pavilion-'+optionValue);
                    shop = pavilion.attr('data-shop');
                    color = pavilion.attr('data-color');
                    this.order_shop = shop;
                    $('#order-shop').css( {'background-color': color } );
                }
            },
            order_floor_pavilion: {
                get() {
                    return this.order_floor_pavilion_raw;
                },
                set (floor) {
                    this.order_floor_pavilion_raw = floor;
                    var pavilions = jQuery.grep(this.order_pavilions_raw, function(element) {
                        return (element['floor'] == floor);
                    });
                    this.order_pavilions = pavilions;
                }
            },
            visual_area_total: function () {
                area = parseFloat(this.visual_height) * parseFloat(this.visual_width)
                if (area > 10000 && area < 1000000) area = (area / 10000).toFixed(2) + " кв.дм"
                else if (area > 999999) area = (area / 1000000).toFixed(2) + " кв.м"
                else area = area.toFixed(2) + " кв.мм"
                return area
            },
            radio_cost: function () {
                return this.radio_price;
            },
            radio_total_price: function () {
                percentage = (this.radio_cost - ( this.radio_cost * this.radio_sale / 100 )).toFixed(2);
                return percentage;
            },
            visual_production_cost: function () {
                return (this.visual_production_price * this.visual_production_quantity);
            },
            visual_production_total_price: function () {
                return percentageCalculate(this.visual_production_cost, this.visual_production_sale);
            },
            visual_placement_cost: function () {
                return (this.visual_placement_price * this.visual_placement_quantity);
            },
            visual_placement_total_price: function () {
                return percentageCalculate(this.visual_placement_cost, this.visual_placement_sale);
            },
            visual_montage_cost: function () {
                return (this.visual_montage_price * this.visual_montage_quantity);
            },
            visual_montage_total_price: function () {
                return percentageCalculate(this.visual_montage_cost, this.visual_montage_sale);
            },
            visual_abs_price: function () {
                return (
                    parseFloat( this.visual_design_total_price ) +
                    parseFloat( this.visual_production_total_price ) +
                    parseFloat( this.visual_placement_total_price ) +
                    parseFloat( this.visual_montage_total_price ) +
                    parseFloat( this.childPlacementCount ) +
                parseFloat( this.childMontageCount )
                ).toFixed(2);
            },
            promo_abs_price: function () {
                return this.promo_cost_payment;
            },
            photo_abs_price: function () {
                return this.photo_cost_payment;
            },
            radio_abs_price: function () {
                return this.radio_total_price;
            },
        },

    });

    function percentageCalculate(price, percent) {
        percentage = (price - ( price * percent / 100 )).toFixed(2);
        return percentage;
    }

    function formSwitch(order) {
        $('#formswitch').val(order);
    }


    // prepare fields «Материалы и исполнение» and «Вид продукции (дубликат)»
    // for value from «Вид продукции»
    visualProduct = $('#visual-product-1');
    text = visualProduct.attr('data-specification');
    $('#materials').val(text);
    productName = visualProduct.attr('data-type');
    $('.production-duplicate').val(productName);

    @if( ! empty($fields))
    // disable default values
    $("[name='order-date']").removeClass("date-now");
    // if mode is «Edit», then restore values from array --------------------
    $( window ).on( "load", function() {

    @if( ! empty($current))
        appOrder.editModeFirstView = true,
        appOrder.order_pavilions = {!! $pavilions !!},
    @endif

    @foreach($fields as $field)
        @if( ! empty($current->{$field->db}))
        @php $value = $current->{$field->db} ?? $field->default_value; @endphp

        @switch($field->type_set)
            @case('val')
                $("[name='{{ $field->js }}']").val('{!! addslashes($value) !!}');
            @break
            @case('app')
                appOrder.{{ $field->vue }} = '{{ $value }}';
                $("input[name='{{ $field->js }}']").trigger('change');
            @break
            @case('text')
                $("#{{ $field->js }}").text('{{ $value }}');
            @break
            @case('radio')
                $("input:radio[name='{{ $field->js }}']").filter("[value='{{ $value }}']").attr('checked', true);
            @break
            @case('attr')
                $("input[name='{{ $field->js }}']").attr('checked', true).trigger('change');
            @break
            @case('json')
                var obj = JSON.parse( '{!! $value !!}' );
                Object.keys(obj).forEach(function(key) {
                    $("#" + key).text(obj[key]);
                });
            @break
        @endswitch
        @endif
    @endforeach

    });
    @endif


    // open order tab ------------------------------------------------------------
    @if( ! empty($current->bypass) && $current->type == 'replacement')
        $('#visual-bypass-categories-block').show();
    @endif

    @if( ! empty($current->orderType))
        $('#link-{{ $current->orderType }}').click();
    @endif

    @if( ! empty($current->orderType) && $current->orderType == 'visual-placement')
        // create surfaces for placement-order editing
        @foreach($current->surfaces as $surface)
            $('#add-placement').click();
        @endforeach
    @elseif( ! empty($current->orderType) && $current->orderType == 'visual-montage')
        // create surfaces for montage-order editing
        @foreach($current->surfaces as $surface)
            $('#add-montage').click();
        @endforeach
    @endif

        if (document.getElementById("radioPeriods")) {
            var simpleEditor = new SimpleTableCellEditor("radioPeriods");
            simpleEditor.SetEditableClass("editMe");
        }

    // Bypass switcher --------------------------------------------------------------
    $("#visual-bypass").on('change', function() {
        if ($(this).is(":checked")) {
            $('#visual-bypass-type-block').show();
            $('#visual-pavilion-block').show();
            if (checkReplacement()) $('#visual-bypass-categories-block').show();
        } else{
            $('#visual-bypass-type-block').hide();
            $('#visual-pavilion-block').hide();
            $('#visual-bypass-categories-block').hide();
        }
    });

    $('#visual-bypass-type').on('change', function() {
        if (checkReplacement()) {
            $('#visual-bypass-categories-block').show();
        } else {
            $('#visual-bypass-categories-block').hide();
        }
    })

    function checkReplacement() {
        var type = $('#visual-bypass-type').val();
        if (type == 'replacement') {
            return true;
        } else {
            return false;
        }

    }
</script>

<div id="app">
    @if (Auth::check())
        @include('chat.index');
    @endif
</div>

</body>
</html>