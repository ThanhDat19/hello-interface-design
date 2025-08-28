<script>
window.routes = {
    // route web
    page_card_index : "{{route('manager.card')}}",
    page_card_create: "{{route('manager.card.create')}}",
    page_card_edit  : "{{route('manager.card.edit', ['id' => ':id_replace'])}}",

    // route API
    get_data_card     : "{{route('api.card.create')}}",
    post_create_card  : "{{route('api.card.create')}}",
    get_data_card_type: "{{route('api.handle.cardtype')}}",
    get_data_edit_card: "{{route('api.card.edit.getdata', ['id' => ':id_replace'])}}",
    post_edit_card    : "{{route('api.card.edit',['id' => ':id_replace'])}}",
}
</script>
