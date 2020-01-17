<template>
    <div>
        <div class="dropdown vue-dropdown overflow-visible" ref="dropdown">
            <div class="btn text-dark dropdown-toggle border btn-block text-left pl-3 shadow-none d-inline-flex" :class="cursor" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @click.prevent>
                <template v-if="searchable">
                    <input type="text" :disabled="input_disabled" v-model="search" class="outline-0 border-0 input-searchable w-100" :placeholder="select_placeholder" ref="input-searchable" :class="{'input-searchable-multiple': multiple}">
                </template>
                <template v-else>
                    <span v-if="!selected_value || selected_value.length == 0" class="text-muted font-weight-normal">{{ select_placeholder }}</span>
                    <span v-else>{{ selected_value.text }}</span>
                </template>
                &nbsp;
            </div>

            <div class="multiple-values">
                <transition-group name="fade" tag="div" v-if="selected_value.length > 0" class="mt-1">
                    <span class="btn btn-xs btn-light bg-light text-dark badge-pill border py-1 px-3 mr-1 mt-1" v-for="(selected, index) in selected_value" :key="selected.value" @click.stop>{{ selected.text }}&nbsp;&nbsp;&nbsp;<i class="fal fa-times cursor-pointer" @click="selected_value.splice(index, 1)"></i></span>
                </transition-group>
            </div>

            <div class="dropdown-menu-container rounded">
                <div class="dropdown-menu w-100 scrollable-menu fade py-0 border-0 rounded-0" ref="dropdown-menu">
                    <span class="dropdown-item disabled pl-3 font-weight-light" v-if="filtered_options.length == 0">
                        <template v-if="show_no_results">No results found</template>
                    </span>
                    <span class="dropdown-item cursor-pointer" v-else :id="'item-'+option.value" :class="{'active': selected_value.value && option.value == selected_value.value}" @click="updateValue(option)" v-for="option in filtered_options">{{ option.text }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            placeholder: {
                type: String,
                default: '',
            },

            options: {
                type: Array,
                default: [],
            },

            value: {
                type: [String, Array, Object],
                default: '',
            },

            multiple: {
                type: Boolean,
                default: false,
            },

            searchable: {
                type: Boolean,
                default: false,
            },
        },

        data: () => ({
            selected_value: [],
            search: '',
            input_disabled: false,
            show_no_results: true,
        }),

        created() {
            this.selected_value = this.value;
        },

        mounted() {
            var self = this;

            $(this.$refs['dropdown']).on('show.bs.dropdown', function(){
                self.show_no_results = true;
                self.search = '';
                self.input_disabled = false;

                if (self.searchable) {
                    setTimeout(function(){
                        self.$refs['input-searchable'].focus();
                    });
                }

                if (!self.multiple && self.selected_value.value) {
                    setTimeout(function(){
                        var pos = document.getElementById('item-'+self.selected_value.value).offsetTop;
                        self.$refs['dropdown-menu'].scrollTop = pos;
                    });
                } else if(self.multiple) {
                    self.$refs['dropdown-menu'].scrollTop = 0;
                }
            });

            $(this.$refs['dropdown']).on('hidden.bs.dropdown', function(){
                self.input_disabled = true;
                self.show_no_results = false;
                if (self.searchable) {
                    self.search = self.selected_value.text || self.placeholder;
                }
            });
        },

        computed: {
            select_placeholder() {
                var placeholder = ''
                if (!this.multiple || this.selected_value) {
                    placeholder = this.selected_value.text || this.placeholder;
                }

                return placeholder;
            },

            filtered_options() {
                var self = this;

                return this.options.filter(function(option) {
                    var show = true;

                    if (self.searchable && self.search.trim().length > 0) {
                        var pos = option.text.toLowerCase().indexOf(self.search.trim().toLowerCase());
                        if (pos != 0) {
                            show = false;
                        }
                    }

                    if (self.multiple && self.selected_value.findIndex(x => x.value == option.value) > -1) {
                        show = false;
                    }

                    return show;
                });
            },

            cursor() {
                return this.searchable ? 'cursor-text' : 'cursor-pointer';
            }
        },

        methods: {
            updateValue(option) {
                if (this.multiple) {
                    this.selected_value.push(option);
                    this.search = this.placeholder;
                } else {
                    this.selected_value = option;
                    this.search = option.text
                }
                this.$emit('change', option);
            },
        },
    }
</script>