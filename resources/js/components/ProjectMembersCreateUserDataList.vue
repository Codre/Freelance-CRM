<template>
    <div>
        <label :for="name + '-input-with-list'" v-html="labelView"></label>
        <b-form-input :id="name + '-input-with-list'" v-model="input" autocomplete="off" :placeholder="placeholder" :name="name" :list="name + '-input-list'" :d="name + '-input-with-list'"></b-form-input>
        <input :value="input" type="hidden" :name="name" :id="name + '-input-list-hidden'" />
        <b-form-datalist :id="name + '-input-list'" :options="optionsList"></b-form-datalist>
    </div>
</template>

<script>
export default {
    name: "ProjectMembersCreateUserDataList",
    props: ['options', 'name', 'placeholder', 'label'],
    data() {
        return {
            input: '',
        }
    },
    computed: {
        optionsList: function() {
            return JSON.parse(this.options);
        },
        labelView : function() {
            return this.label + (this.input > 0 ? ( ' <b>(' + JSON.parse(this.options)[this.input] + ')</b>' ) : '');
        }
    }
}
</script>
