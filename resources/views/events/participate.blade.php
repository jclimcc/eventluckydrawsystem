@extends('layouts.app')

@section('content')

    <h1>Participate in {{ $event->name }}</h1>
    
    <div id="app" data-event-id="{{ $event->id }}">   
        <span v-cloak v-if="message"  :class="messageClass">@{{ message }}</span>
    <form @submit="submitForm">
        @csrf
        <!-- Add fields for visitor information here -->
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" v-model="name" required>
        </div>
        <div>
            <label for="phone">Phone:</label>
            <input type="text" id="contact_number" v-model="contact_number" required>
            <div v-if="errors.contact_number" class="alert alert-danger">
                @{{ errors.contact_number[0] }}
            </div>
        </div>
        <div>
            <label for="email">Email Address:</label>
            <input type="email" id="email"  v-model="email" required>
        </div>
        <button type="submit">Participate</button>
    </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@0.21.1/dist/axios.min.js"></script>
    <script>
       
        new Vue({
            el: '#app',
            data: {
                name: '',
                contact_number: '',
                email: '',
                errors: {},
                eventId: null,
                message: '',  
                messageClass: ''  
            },
            mounted() {
                this.eventId = this.$el.dataset.eventId;  // Add this line
                this.message='';
               
            },
            methods: {
                submitForm(event) {
                    event.preventDefault();
               
                    axios.post('/events/' + this.eventId + '/participate', {
                        name: this.name,
                        contact_number: this.contact_number,
                        email: this.email
                    })
                    .then(response => {
                        // Handle success here
                        this.message = response.data.message;
                        this.messageClass = 'success';
                        this.errors = {};  // Clear any existing errors
                        console.log(this.messageClass);
                         // Remove the message after 5 seconds
                        setTimeout(() => {
                            this.message = '';
                            this.name='';
                            this.contact_number='';
                            this.email='';
                            
                        }, 3000);
                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors;
                            // Set the message to the first error message
                            
                            for (let field in this.errors) {
                                this.message = this.errors[field][0];
                                break;
                            }
                            this.messageClass = 'error';
                             // Remove the message after 5 seconds
                            setTimeout(() => {
                                this.message = '';
                            }, 5000);
                        }
                    });
                }
            }
        });
    
    </script>
@endsection