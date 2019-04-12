<template>
    <div class="row justify-content-center mt-3">
    <div class="col-md-6">
    <h1 class="text-center">Contacts</h1>
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
            <button v-show="!edit" type="submit" class="btn btn-primary btn-block">Create Contact</button>
            <button v-show="edit" type="submit" class="btn btn-primary btn-block">Edit Contact</button>
        </div>
    </form>
    <h1 class="text-center">Contacts List</h1>
    <ul class='list-group mt-2' v-for='contact in list'>
        <li class="list-group-item text-center"><strong> {{ contact.name }} </strong></li> 
        <li class="list-group-item text-center"> {{ contact.email }} </li> 
        <li class="list-group-item text-center"> {{ contact.phone }} </li> 
        <li class="list-group-item"> 
            <button @click="showContact(contact.id)" class="btn btn-default btn-block">Edit</button> 
            <button @click="deleteContact(contact.id)" class="btn btn-danger btn-block mt-1">Delete</button>
        </li> 
    </ul>
    </div>
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
        
        showContact : function(id) {
            console.log('show contact....')
            let self = this;
            axios.get('api/contact/'+id)
                .then(function(response) {
                    self.contact.id = response.data.id;
                    self.contact.name = response.data.name;
                    self.contact.email = response.data.email;
                    self.contact.phone = response.data.phone;
                    self.edit = true;
                })
                .catch(function(error) {
                    console.log(error);
                });
        },

        updateContact : function(id) {
            console.log('Updating contacts....')
            let self = this;
            let parameters = Object.assign({}, self.contact);
            axios.patch('api/contact/'+id,parameters)
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

        deleteContact : function (id) {
            let self = this;
            axios.delete('api/contact/delete/'+id)
                .then(function(response) {
                    self.fetchContactList();
                })
                .catch(function(error) {
                    console.log(error);
                });
        }
    }
}
</script>