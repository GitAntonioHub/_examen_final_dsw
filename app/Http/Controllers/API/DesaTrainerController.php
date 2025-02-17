namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DesaTrainer;

class DesaTrainerController extends Controller
{
    public function index()
    {
        $desaTrainers = DesaTrainer::with(['scenarios' => function($query) {
            $query->select('id', 'name', 'description');
        }, 'instructions' => function($query) {
            $query->select('id', 'name');
        }])->get();

        return response()->json($desaTrainers);
    }
}
