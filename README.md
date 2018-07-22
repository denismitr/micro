# Micro
Micro is a minimalistic framework to build REST API's with JWT authentication baked in

## Installation

`composer create-project denismitr/micro projectname`

## MIgrations

#### Modify table
`phinx create AddIsAdminToUsersTable`

and add required changes under `$this-schema->table('table_name)`:

```php
class AddIsAdminToUsersTable extends Migration
{
    public function up()
    {
        $this->schema->table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false);
        });
    }

    public function down()
    {
        $this->schema->table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin');
        });
    }
}
```