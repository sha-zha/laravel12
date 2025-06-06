namespace App\View\Components;

use Illuminate\View\Component;

class Table extends Component
{
    public $data;
    public $headers;

    public function __construct($data, $headers = [], $routeName)
    {
        $this->data = collect($data);
        $this->headers = $headers;
        $this->routeName = $routeName;
    }

    public function render()
    {
        return view('components.table');
    }
}
