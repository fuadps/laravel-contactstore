<template>
    <div>
    <h1>Contacts</h1>
    <form action="#"  @submit.prevent = "edit ? updateContact(contact.id) : createContact()">
        <div class="form-group">
            <label>Name : </label>
            <input v-model="contact.name" type="text" name="name" class="form-control"/>
        </div>
        <div class="form-group">
            <label>Email : </label>
            <input v-model="contact.email" type="text" name="email" class="form-control"/>
        </div>
        <div class="form-group">
            <label>Phone : </label>
            <input v-model="contact.phone" type="text" name="phone" class="form-control"/>
        </div>
        <div class="form-group">
            <button v-show="!edit" type="submit" class="btn btn-primary">Create Contact</button>
            <button v-show="edit" type="submit" class="btn btn-primary">Edit Contact</button>
        </div>
    </form>
    </div>
</template>

<script>
export default {
    data : function() {
        return {
            edit: false,
            list: [],
            contact: {
                id:'',
                name:'',
                email:'',
                phone:''
            }
        }
    },
    mounted: function() {
        console.log('Contacts component loaded...');
        this.fetchContactList();
    },
    methods: {
        fetchContactList: function() {
            console.log('fetching contact list...');
            axios.get('api/contacts')
                .then((response) => {
                    console.log(response.data);
                    this.list = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        createContact : function() {
            console.log('create contact...');
            
            let self = this;
            let parameters = Object.assign({}, self.contact);
            axios.post('api/contact/store',parameters)
                .then(function() {
                self.contact.name = '';
                self.contact.email = '';
                self.contact.phone = '';
                self.edit = false;
                self.fetchContactList();
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        updateContact : function() {

        }
    }
}
</script>