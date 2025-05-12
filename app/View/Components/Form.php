namespace App\View\Components;

use Illuminate\View\Component;

class Form extends Component
{
    public $model;
    public $action;
    public $method;

    public function __construct($model, $action, $method = 'POST')
    {
        $this->model = $model;
        $this->action = $action;
        $this->method = strtoupper($method);
    }

    public function render()
    {
        return view('components.form');
    }
}
