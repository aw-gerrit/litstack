<template>
    <div class="d-flex align-items-center">
        <lit-field :model="item" :field="field" />
    </div>
</template>

<script>
export default {
    name: 'FieldRelationColField',
    props: {
        item: {
            type: Object,
        },
        colField: {
            type: Object,
        },
        model: {
            type: Object,
        },
    },
    data() {
        return {
            field: {},
        };
    },
    beforeMount() {
        this.field = this.setFieldRoutePrefixId(
            Lit.clone(this.colField),
            this.item
        );
    },
    methods: {
        setFieldRoutePrefixId(field, relation) {
            field.route_prefix = field.route_prefix.replace(
                '{id}',
                this.model.id
            );
            field.params.relation_id = relation.id;

            return field;
        },
    },
};
</script>
