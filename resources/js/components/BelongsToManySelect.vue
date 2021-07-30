<template>
    <div>
        <div class="border" style="padding: 0px 10px 10px; border-radius: 2px; margin: 0px 0px 10px;">
            <h4>
                <i class="fa fa-bars"></i> {{ field.label }}
                <span v-if="field.info">
                    <i class="fa fa-info-circle" v-tooltip:top="field.info"></i>
                </span>
            </h4>

            <div class="form-group">
                <input type="hidden" :value="field.value" :name="field.name + '[crud_worker]'">

                <template v-if="field.config.auto_complete">
                    <autocomplete
                        v-if="!field.config.disabled"
                        ref="autocomplete"
                        input-class="form-control"
                        :source="notSelected"
                        :results-display="formattedDisplay"
                        :results-formatter="resultsFormatter"
                        @selected="select">
                    </autocomplete>
                </template>
                <template v-else>
                    <select v-if="!field.config.disabled" class="form-control" v-bind="fieldAttributes" @change="select"
                            v-model="selected_id">
                        <option value="0">
                            <template v-if="notSelected.length">
                                Please select...
                            </template>
                            <template v-else>
                                No {{ field.label.toLowerCase() }} available
                            </template>
                        </option>
                        <option
                            :value="item.id"
                            v-for="item in notSelected">
                            {{ item[field.config.title_property] }}
                        </option>
                    </select>
                </template>
            </div>
            <div class="form-group">
                <table v-if="selected.length" class="belongs-to-many-table table table-striped">
                    <thead>
                    <tr>
                        <th v-for="column in field.config.columns">
                            {{ normalizeText(column) }}
                        </th>

                        <th v-for="field in field.pivot_fields">
                            {{ field.label }}
                        </th>

                        <th v-if="!field.config.disabled"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item, index) in selected">
                        <input type="hidden" :name="field.name + '[' + index + ']'" :value="item.id">

                        <td v-for="column in field.config.columns">
                            {{ item[column] }}
                        </td>

                        <td v-for="(pivotField, index) in item.fields">
                            <component
                                :is="pivotField.type + '-field'"
                                :field="pivotField"
                                :language="language"
                                :key="index"
                            ></component>
                        </td>

                        <td v-if="!field.config.disabled" class="text-right">
                            <button type="button" class="btn btn-danger btn-sm" @click="unselect(item)">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <div v-else class="alert alert-info">
                    <template v-if="field.config.not_selected_message">
                        {{ field.config.not_selected_message }}
                    </template>
                    <template v-else>
                        No {{ field.label.toLowerCase() }} selected
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Autocomplete from 'vuejs-auto-complete'
    import _ from 'lodash';

    export default {
        props: ['field', 'language'],

        components: {
            Autocomplete
        },

        data() {
            return {
                name: null,
                id: null,
                selected_id: 0,
                selected: []
            }
        },

        computed: {
            notSelected() {
                let selectedIds = _.map(this.selected, 'id');

                return _.filter(this.field.items, object => {
                    return selectedIds.indexOf(object.id) <= -1
                });
            }
        },

        created() {
            let [name, tempId] = this.field.name.split('[');

            this.name = name;
            this.id = tempId ? tempId.slice(0, -1) : 0;

            this.field.items.forEach(item => {
                item.fields.forEach(field => {
                    field.name = field.name.replace(/__ID(\S+)__/gi, this.id)
                });

                if (item.is_selected) {
                    this.selected.push(item);
                }
            });
        },

        methods: {
            normalizeText(text) {
                text = text.split('_').join(' ');

                return text.charAt(0).toUpperCase() + text.slice(1).toLowerCase();
            },

            formattedDisplay(result) {

                if (!this.field.config.title_peoperty && typeof result["first_name"] !== "undefined" && typeof result["last_name"] !== "undefined") {
                    return '#' + result['id'] + ' - ' + result["first_name"] + ' ' + result["last_name"]
                }

                return '#' + result['id'] + ' - ' + result[this.field.config.title_property];
            },

            resultsFormatter(objects) {
                let selectedIds = _.map(this.selected, 'id');

                objects = _.filter(objects, object => {
                    return selectedIds.indexOf(object.id) <= -1
                });

                return objects;
            },

            select(result) {
                let item;

                if (this.field.config.auto_complete) {
                    item = result.selectedObject;
                } else {
                    item = _.find(this.field.items, item => {
                        return item.id === parseInt(result.target.value);
                    });
                }

                item.fields.forEach(field => {
                    field.label = null;

                    if (field.value === '' && typeof this.field.config.links[field.field_name] !== 'undefined') {
                        field.value = parseFloat(item[this.field.config.links[field.field_name]]);
                    }
                });

                if (item) {
                    this.selected.push(item);
                }

                this.selected_id = 0;

                if (this.field.config.auto_complete) {
                    this.$refs.autocomplete.clear()
                }

                this.emitInput();
            },

            unselect(item) {
                let index = _.findIndex(this.selected, selected => {
                    return selected.id === item.id;
                });

                this.selected.splice(index, 1);

                this.emitInput();
            },

            emitInput() {
                this.$nextTick(() => {
                    if (this.id) {
                        $(`input[name^="${this.name}[${this.id}"]`).trigger('input');

                        return true;
                    }

                    $(`input[name^="${this.name}`).trigger('input');
                })
            }
        }
    }
</script>

<style>
    .belongs-to-many-table label {
        display: none;
    }
</style>
