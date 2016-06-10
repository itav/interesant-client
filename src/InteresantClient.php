<?php

namespace App;

class InteresantClient
{
    public function getInteresants()
    {
        $interesants = [];
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'http://interesant.dev/list', [

        ]);
        
        if ($res->getStatusCode() == 200){
        
            $json = $res->getBody();
            $serializer = new \Itav\Component\Serializer\Serializer();
            $interesants = $serializer->unserialize($json, Interesant::class . '[]');
            return  $interesants;
        }
        return $interesants;
    }
    
    /**
     * @param Interesant $interesant 
     * @return Form\Select
     */
    public function getSelectInteresant($interesant)
    {
        $select = new \Itav\Component\Form\Select();
        $client = new \GuzzleHttp\Client();
        $res = $client->get('http://interesant.dev/form');
        
        if ($res->getStatusCode() == 200){
        
            $json = $res->getBody()->read(1024000);
            $serializer = new \Itav\Component\Serializer\Serializer();
            $serializer->unserialize($json, \Itav\Component\Form\Select::class, $select);
        }
        return $select;
    }
    
    /**
     * @param string $id 
     * @return Form\Select
     */
    public function getInteresantById($id)
    {
        $interesant = new Interesant();
        $client = new \GuzzleHttp\Client();
        $res = $client->get("http://interesant.dev/info/$id", [
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]);
        
        if ($res->getStatusCode() == 200){
        
            $json = $res->getBody()->getContents();
            $serializer = new \Itav\Component\Serializer\Serializer();
            $serializer->unserialize($json, Interesant::class, $interesant);
        }
        return $interesant;
    }    
}