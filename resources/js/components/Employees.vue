<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-12 justify-content-center">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Employees Table</h3>

                <div class="card-tools">
                    <button class="btn btn-success" @click="addNewModal">Add New <i class="fas fa-user-plus fa-fw"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Contact Number</th>
                      <th>NIC</th>
                      <th>Modify</th>

                    </tr>
                  </thead>
                  <tbody>

                    <tr v-for="employee in employees.data" :key="employee.employee_id">
                      <td>{{employee.employee_id}}</td>
                      <td>{{employee.employee_name | toUpper}}</td>
                      <td>{{employee.employee_contact_number}}</td>
                      <td>{{employee.employee_NIC}}</td>
                      <td>
                          <a href="#" @click="editModal(employee)"><i class="fas fa-edit"></i></a>
                          /
                          <a href="#" @click="deleteEmployee(employee.employee_id)"><i class="fas fa-trash-alt red"></i></a>
                      </td>
                    </tr>
                  </tbody>
                  <div class="card-footer">
                      <pagination :data="employees" @pagination-change-page="getResults"></pagination>
                  </div>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- Modal -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="addEmployeeTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 v-show="!editMode" class="modal-title" id="addEmployeeModalLongTitle">Add New Employee</h5>
        <h5 v-show="editMode" class="modal-title" id="addEmployeeModalLongTitle">Update Employee Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form @submit.prevent="editMode ? updateEmployee():createEmployee()">
      <div class="modal-body">

            <div class="form-group">
                <input v-model="form.employee_name" type="text" name="employee_name"
                placeholder="Employee Name"
                class="form-control" :class="{ 'is-invalid': form.errors.has('employee_name') }">
                <has-error :form="form" field="employee_name"></has-error>
            </div>

            <div class="form-group">
                <textarea v-model="form.address" name="address" placeholder="Employee Address"
                class="form-control" :class="{ 'is-invalid': form.errors.has('address') }">
                </textarea>
                <has-error :form="form" field="address"></has-error>
            </div>

            <div class="form-group">
                <input v-model="form.employee_NIC" type="text" name="employee_NIC"
                placeholder="Employee NIC"
                class="form-control" :class="{ 'is-invalid': form.errors.has('employee_NIC') }">
                <has-error :form="form" field="employee_NIC"></has-error>
            </div>

            <div class="form-group">
                <input v-model="form.employee_contact_number" type="text" name="employee_contact_number"
                placeholder="Employee Contact Number"
                class="form-control" :class="{ 'is-invalid': form.errors.has('employee_contact_number') }">
                <has-error :form="form" field="employee_contact_number"></has-error>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button v-show="!editMode" type="submit" class="btn btn-primary">Create</button>
        <button v-show="editMode" type="submit" class="btn btn-primary">Update</button>
      </div>
      </form>
    </div>
  </div>
</div>
        </div>
</template>

<script>
    export default {
        data(){
            return{
                editMode : true,
                employees : {},
                form : new Form({
                employee_id : '',
                employee_name : '',
                address : '',
                employee_NIC : '',
                employee_contact_number : ''
                }),
            }
        },
        methods : {
            getResults(page = 1) {
                axios.get('api/employees?page=' + page)
                    .then(response => {
                        this.employees = response.data;
                    });
            },
            updateEmployee(){
                this.$Progress.start();
                this.form.put('api/employees/'+this.form.employee_id)
                .then(()=>{
                    $('#addEmployeeModal').modal('hide');
                    Toast.fire({
                    icon: 'success',
                    title: 'Employee updated succesfully!'
                    });
                    this.$Progress.finish();
                    Fire.$emit('AfterCreate');
                    this.$Progress.finish();
                })
                .catch(()=>{
                    this.$Progress.fail();
                    Swal("Failed!","There is something wrong.","warning");
                });
            },
            editModal(employee){
                this.editMode = true;
                this.form.reset();
                $('#addEmployeeModal').modal('show');
                this.form.fill(employee);
            },
            addNewModal(){
                this.editMode = false;
                this.form.reset();
                $('#addEmployeeModal').modal('show');
            },
            deleteEmployee(employee_id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {
                    this.form.delete('api/employees/'+employee_id)
                    .then(()=>{

                    swalWithBootstrapButtons.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                    );
                    Fire.$emit('AfterCreate');
                    })
                    .catch(()=>{
                        Swal("Failed!","There is something wrong.","warning");
                    });

                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {

                }
                })
            },
            loadEmployees(){
                axios.get('api/employees')
                .then(({data})=>{
                    this.employees = data;
                }
                );
            },
            createEmployee(){
                this.$Progress.start();
                this.form.post('api/employees')
                .then(()=>{
                    $('#addEmployeeModal').modal('hide');
                    Toast.fire({
                    icon: 'success',
                    title: 'Signed in successfully'
                    });
                    this.$Progress.finish();
                    Fire.$emit('AfterCreate');
                 })
                 .catch((error)=>{
                     this.$Progress.fail();
                 });

            },
        },
        created() {
            this.loadEmployees();
            Fire.$on('AfterCreate',()=>{
                this.loadEmployees();
            });
        }
    }
</script>
