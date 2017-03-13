<?php
namespace Gsync_Api\V1\Rest\Calender_Service;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use Zend\Paginator\Adapter\ArrayAdapter;

require_once 'quickstart.php';
//require_once 'create_event.php';

class Calender_ServiceResource extends AbstractResourceListener
{
    private function getData()
    {
        return array(
            1 => array(
                'calender_service_id' => 1,
                'text' => 'I may throw up on ya.',
                'who' => 'Leonard McCoy',
            ),
            2 => array(
                'calender_service_id' => 2,
                'text' => 'I think these things are pretty safe.',
                'who' => 'James T. Kirk'
            ),
            3 => array(
                'calender_service_id' => 3,
                'text' => 'Well, I hate to break this to you, but Starfleet operates in space.',
                'who' => 'James T. Kirk'
            ),
            4 => array(
                'calender_service_id' => 4,
                'text' => 'Yeah. Well, I got nowhere else to go. The ex-wife took the whole damn planet in the divorce. All I got left is my bones.',
                'who' => 'Leonard McCoy'
            ),
            5 => array(
                'calender_service_id' => 5,
                'text' => 'If you eliminate the impossible, whatever remains, however improbable, must be the truth.',
                'who' => 'Spock'
            )
        );
    }

    /**
     * Fetch a resource
     */
    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */

    public function fetch($id)
    {
        return new Calender_ServiceEntity($this->getData()[$id]);
      //  return new Calender_ServiceEntity($this->getData()[$id]);
    }


    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */


    public function fetchAll($params = array())
    {
        $adapter = new ArrayAdapter($this->getData());
        $collection = new Calender_ServiceCollection($adapter);
        return $collection;
    }
    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
         $obj = json_decode($data);
         $ans = array(
             'access_token'  => $data->access_token,
             'Subject' => $data->EventSubject,
             'Description'  => 'Spock1 Afghani'
         );

        return $ans;

        $client = getClient($data);


        /*$ans1 = array();
        $i=0;
        $obj = json_decode($json1);
        //$obj = json_decode(file_get_contents("php://in‌​put"));



        for($j=0; $j < count($obj); $j++)
        {
            $ans1[] = array(
                'calender_service_id'  => 2,
                'text' => $obj[$j]->{'firstName'},
                'access_token'  => $obj[$j]->{'lastName'}
            );

            $i++;
        }*/
        return $client;//new OCookieEntity($ans);
        //return new ApiProblem(405, 'The POST method has not been defined');
    }


    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }


    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }
}


