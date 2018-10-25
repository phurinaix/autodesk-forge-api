<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class AutodeskController extends Controller{

    public function checkAuth(){
        $client_id = 'pAyMDWUOsdvc28wUp1HaNCYSTeutf6jG';
        $client_secret = 'nMRiJWrYbdLkyU3D';
        $grant_type = 'client_credentials';
        $scope = 'viewables:read%20data:write%20data:read%20bucket:create%20bucket:read';
        $header = array('Content-Type: application/x-www-form-urlencoded');
        $curl = curl_init('https://developer.api.autodesk.com/authentication/v1/authenticate');
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_POSTFIELDS, "client_id=$client_id&client_secret=$client_secret&grant_type=$grant_type&scope=$scope");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $response = json_decode($response, true);
        curl_close($curl);

        return $response;
    }
    public function createBucket() {
        $data = json_encode([
            'bucketKey' => 'phurinatnnnnnnkpjpopoopupoipo',
            'policyKey' => 'persistent'
        ]);
        $headers = array('Content-Type: application/json','Authorization: Bearer '. $this->checkAuth()["access_token"]);
    
        $curl = curl_init('https://developer.api.autodesk.com/oss/v2/buckets');
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    // get all buckets
    public function getBuckets(){
        $headers = array('Content-Type: application/json','Authorization: Bearer '. $this->checkAuth()["access_token"]);
    
        $curl = curl_init('https://developer.api.autodesk.com/oss/v2/buckets');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    // get bucket by bucket key
    public function getBucket($bucketKey){
        $headers = array('Content-Type: application/json','Authorization: Bearer '. $this->checkAuth()["access_token"]);
    
        $curl = curl_init('https://developer.api.autodesk.com/oss/v2/buckets/'.$bucketKey.'/details');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    // upload an object
    public function putObjects($bucketKey, $objectName) {
        $headers = array('Content-Type: text/plain; charset=UTF-8', 'Authorization: Bearer '. $this->checkAuth()["access_token"]);

        $curl = curl_init('https://developer.api.autodesk.com/oss/v2/buckets/'.$bucketKey.'/objects/'.$objectName);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
        // curl_setopt($curl, CURLOPT_POSTFIELDS)
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    // allows resumable uploads for large files in chunks (> 100MB)
    public function putLargeObjects($bucketKey, $objectName) {
        $headers = array('Content-Type: text/plain; charset=UTF-8', 'Content-Range: bytes 1-15/100', 'Session-Id: 1', 'Authorization: Bearer '. $this->checkAuth()["access_token"]);

        $curl = curl_init('https://developer.api.autodesk.com/oss/v2/buckets/'.$bucketKey.'/objects/'.$objectName.'/resumable');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($curl, CURLOPT_POSTFIELDS, 'five-five-five-');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    // get status information about a resumable upload
    public function getStatusLargeObjectUpload($bucketKey, $objectName, $sessionId) {
        $headers = array('Authorization: Bearer '. $this->checkAuth()["access_token"]);

        $curl = curl_init('https://developer.api.autodesk.com/oss/v2/buckets/'.$bucketKey.'/objects/'.$objectName.'/status/'.$sessionId);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    // List objects in a bucket
    public function getObjects($bucketKey) {
        $headers = array('Content-Type: application/json','Authorization: Bearer '. $this->checkAuth()["access_token"]);
    
        $curl = curl_init('https://developer.api.autodesk.com/oss/v2/buckets/'.$bucketKey.'/objects');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    // returns single object details
    public function getObject($bucketKey, $objectName) {
        $headers = array('Content-Type: application/json','Authorization: Bearer '. $this->checkAuth()["access_token"]);
    
        $curl = curl_init('https://developer.api.autodesk.com/oss/v2/buckets/'.$bucketKey.'/objects/'.$objectName.'/details');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    // Download an Object
    public function downloadObject($bucketKey, $objectName) {
        $headers = array('Content-Type: application/json','Authorization: Bearer '. $this->checkAuth()["access_token"]);
    
        $curl = curl_init('https://developer.api.autodesk.com/oss/v2/buckets/'.$bucketKey.'/objects/'.$objectName);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    // signed object
    public function signURL($bucketKey, $objectName){
        $headers = array('Content-Type: application/json', 'Authorization: Bearer '. $this->checkAuth()["access_token"]);
    
        $curl = curl_init('https://developer.api.autodesk.com/oss/v2/buckets/'.$bucketKey.'/objects/'.$objectName.'/signed?access=write');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, '{}');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    // signed Resource
    public function signResource($id) {
        $headers = array('Content-Type: text/plain; charset=UTF-8', 'Authorization: Bearer '. $this->checkAuth()["access_token"]);
    
        $curl = curl_init('https://developer.api.autodesk.com/oss/v2/signedresources/'.$id);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    // Resumable upload for signed URLs
    public function signResourceResumable($id) {
        $headers = array('Content-Type: text/plain; charset=UTF-8', 'Authorization: Bearer '. $this->checkAuth()["access_token"]);
    
        $curl = curl_init('https://developer.api.autodesk.com/oss/v2/signedresources/'.$id.'/resumable');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    // Download an object using a signed URL
    public function downLoadSignedURL($id) {
        $headers = array('Content-Type: text/plain; charset=UTF-8', 'Authorization: Bearer '. $this->checkAuth()["access_token"]);
    
        $curl = curl_init('https://developer.api.autodesk.com/oss/v2/signedresources/'.$id);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    // Delete a signed URL
    public function deleteSignedURL($id) {
        $headers = array('Authorization: Bearer '. $this->checkAuth()["access_token"]);
    
        $curl = curl_init('https://developer.api.autodesk.com/oss/v2/signedresources/'.$id);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    // Copies an object to another object name in the same bucket
    public function copyObject($bucketKey, $objectName, $newObjectName) {
        $headers = array('Authorization: Bearer '. $this->checkAuth()["access_token"]);
    
        $curl = curl_init('https://developer.api.autodesk.com/oss/v2/buckets/'.$bucketKey.'/objects/'.$objectName.'/copyto/'.$newObjectName);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    // Deletes an object from the bucket
    public function deleteObject($bucketKey, $objectName) {
        $headers = array('Authorization: Bearer '. $this->checkAuth()["access_token"]);
    
        $curl = curl_init('https://developer.api.autodesk.com/oss/v2/buckets/'.$bucketKey.'/objects/'.$objectName);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    /*
    public function getMetadata(){
        $response = Curl::to('  https://developer.api.autodesk.com/modelderivative/v2/designdata/:urn/metadata')
        ->withContentType('application/x-www-form-urlencoded')
        ->withData([
            'client_id' => 'HJnMTkXTBlpgKGUOVVw78pdyqt1S5F8g',
            'client_secret' => 'cgDXnxjUTPQ1ze6M',
            'grant_type' => 'client_credentials',
            'scope' => 'viewables:read data:write data:read bucket:create bucket:read'
        ])->post();t()
        ->post();
    }
    public function checkManifest(){
        $curl = curl_init('https://developer.api.autodesk.com/modelderivative/v2/designdata/dXJuOmFkc2sub2JqZWN0czpvcy5vYmplY3Q6YmltZGF0YWJhc2V0ZXRyaWRlbnR3ZWIvbWNFbGVjdHJpY2FsX3Rpc190NXRndnp3bG5xLnJ2dA/manifest')
        // $response = Curl::to('https://developer.api.autodesk.com/modelderivative/v2/designdata/dXJuOmFkc2sub2JqZWN0czpvcy5vYmplY3Q6YmltZGF0YWJhc2V0ZXRyaWRlbnR3ZWIvbWNFbGVjdHJpY2FsX3Rpc190NXRndnp3bG5xLnJ2dA/manifest')
        ->withContentType('application/json')
        ->withHeader('Authorization: Bearer '.$this->checkAuth())
        ->get();
        return $response;
    }
    public function getHubs(){
        $response = Curl::to('https://developer.api.autodesk.com/project/v1/hubs')
        ->withContentType('application/json')
        ->withHeader('Authorization: Bearer '.$this->checkAuth())
        ->get();
        //$response = json_decode($response, true);
        return $response;
    }
    public function getProject(){
        $response = Curl::to('https://developer.api.autodesk.com/hq/v1/regions/eu/accounts/6d4999c0-373b-4916-bd62-37562fea8e66/projects')
        ->withContentType('application/json')
        ->withHeader('Authorization: Bearer '.$this->checkAuth())
        ->get();
        //$response = json_decode($response, true);
        return $response;
    }
    public function get3DModels(){
        $response = Curl::to('https://developer.api.autodesk.com/oss/v2/buckets/bimdatabasedev/objects')
        ->withHeader('Authorization: Bearer '.$this->checkAuth())
        ->withContentType('application/json')
        ->get();
        $response = json_decode($response, true);
        return $response;
    }
    */
}
