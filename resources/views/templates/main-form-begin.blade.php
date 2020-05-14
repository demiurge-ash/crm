@php
    $userName = Auth::user()->name;
    $userId = Auth::user()->id;
@endphp

   @csrf
    <div class="container" id="order-container">

        <div class="row">
            <div class="col-xs-12">
                <h3 id="main-manager-name">
                    {{ $userName }}
                </h3>
                <input type="hidden" name="main-manager" value="{{ $userId }}">
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <label class="control-label" for="manager">Добавить менеджера</label>

                    @if( ! empty($managers) && count($managers))
                        <select class="form-control"
                                id="manager"
                                name="order-manager"
                                v-model="order_manager">
                            <option value="0">не добавлять</option>
                            @foreach($managers as $item)
                                @if($item->id != $userId)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    @endif

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="form-group">
                    <label class="control-label" for="number">Заказ №</label>
                    <input type="text"
                           class="form-control"
                           id="number"
                           name="order-number"
                           placeholder="автоматически, после создания"
                           readonly>
                </div>
            </div>

            <div class="ol-sm-6 col-md-4">
                <div class="form-group">
                    <label class="control-label">Дата заказа</label>
                    <div class="form-group datetimepicker" id="orderdate"><!-- class="input-group" -->
                        <input type="datetime" class="form-control date-now" name="order-date" readonly>
                        <!--
                        <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                        -->
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <label class="control-label" for="ordertype">Тип заказа</label>

                    @if( ! empty($types) && count($types))
                        <select class="form-control"
                                id="ordertype"
                                name="order-type"
                                v-model="order_type">
                            @foreach($types as $item)
                                <option value="{{ $item->id }}">{{ $item->type }}</option>
                            @endforeach
                        </select>
                    @endif

                </div>
            </div>

        </div>
        <br>
        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="form-group">
                    <label class="control-label" for="building">Строение</label>
                    <select class="form-control"
                            id="building"
                            name="order-building"
                            v-model="selectedBuilding">
                        <option value="0">—</option>
                        <option v-for="building in order_building" :value="building.id">
                            @{{ building.building }}
                        </option>
                    </select>

                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-2">
                <div class="form-group">
                    <label class="control-label" for="floor-pavilion">Этаж</label>
                    <select class="form-control"
                            id="floor-pavilion"
                            name="order-floor-pavilion"
                            v-model="order_floor_pavilion">
                        <option v-for="floor_pavilion in order_floor_pavilions"
                                :id="'order-floor-pavilion-' + floor_pavilion.id"
                                :value="floor_pavilion.id">@{{floor_pavilion.name}}</option>
                    </select>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="form-group">
                    <label class="control-label" for="pavilion">Павильон №</label>
                    <select class="form-control"
                            id="pavilion"
                            name="order-pavilion"
                            v-model="order_pavilion">
                        <option :value="0">—</option>
                        <option v-for="pavilion in order_pavilions"
                            :id="'order-pavilion-' + pavilion.id"
                            :data-shop="pavilion.shop"
                            :data-color="pavilion.paint ? pavilion.paint.color : ''"
                            :value="pavilion.id">@{{pavilion.pavilion}}</option>
                    </select>

{{--
                    <v-select
                            class="form-control"
                            id="pavilion"
                            :options="order_pavilions"
                            v-model="order_pavilion"
                            :reduce="pavilion => pavilion.id"
                            :selected="order_pavilion_raw"
                            label="pavilion">
                    </v-select>
                    <input type="hidden" name="order-pavilion" :value="order_pavilion_raw" />
--}}
{{--
                    <Dropdown
                            :options="order_pavilions"
                            --}}
{{--v-on:selected="validateSelection"--}}{{--

                            --}}
{{--v-on:filter="getDropdownValues"--}}{{--

                            :disabled="false"
                            name="order-pavilion"
                            :maxItem="100"
                            placeholder="Please select an option">
                    </Dropdown>
--}}
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="form-group">
                    <label class="control-label" for="order-shop">Магазин</label>
                    <input type="email"
                           class="form-control"
                           id="order-shop"
                           name="order-shop"
                           v-model="order_shop"
                           readonly
                    >
                </div>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4">

                <div class="form-group">

                    <label class="control-label" for="name">Клиент</label>
                    <div class="input-group">
                        <input type="text"
                               id="name"
                               name="order-client-name"
                               class="form-control"
                               v-model="order_client_name"
                               list="clients">
                        @if( ! empty($clients))
                        <datalist id="clients">
                            @foreach($clients as $client)
                            <option value="{{ $client->name }}"
                                    id="order-client-{{ $client->id }}"
                                    data-title="{{ $client->description }}"
                                    data-phone="{{ $client->phone }}"
                                    data-email="{{ $client->email }}"
                            >
                            @endforeach
                        </datalist>
                        <span class="input-group-addon input-group-addon_help">
                        <a href="#" data-toggle="tooltip" data-placement="left" title="Обязательное поле"
                           class="icon-help" id="client-description">
                            ?
                        </a>
                        </span>
                        @endif
                    </div>

                </div>

            </div>

            <div class="col-sm-6 col-md-3">
                <div class="form-group">
                    <label class="control-label" for="order-client-phone">Телефон</label>
                    <input type="tel"
                           class="form-control"
                           id="order-client-phone"
                           name="order-client-phone"
                           v-model="order_client_phone">
                </div>
            </div>

            <div class="col-sm-6 col-md-4">
                <div class="form-group">
                    <label class="control-label" for="order-client-email">E-mail</label>
                    <input type="email"
                           class="form-control"
                           id="order-client-email"
                           name="order-client-email"
                           v-model="order_client_email">
                </div>
            </div>

        </div>

        <hr class="small">