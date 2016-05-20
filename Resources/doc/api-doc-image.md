# Image upload API

## Create an image

```
    POST /api/media/image
```     

#### Headers
```
    Content-Type: image/jpeg
```

#### Body
```
    $imageBinaryData
```

#### Response headers

``` 
    Status Code: 200 OK
    Content-Type: application/json; charset=UTF-8
```

#### Response body
```json
    {
        "id": 5,
        "url": "http:\/\/127.0.0.1:8080\/media\/image\/c8\/36\/c836eef9d5c393d35a6cbb048ddc4b1e.jpg",
        "preview":{"thumbnail":"http:\/\/127.0.0.1:8080\/media\/image\/c2\/2d\/c22dd7836bbeb635736cd4a7e96f9145.jpg"}
    }
```

## Update an image

```
    PUT /api/media/image/{imageId}
```     

#### Headers
```
    Content-Type: image/jpeg
```

#### Body
```
    $imageBinaryData
```

#### Response headers

``` 
    Status Code: 200 OK
    Content-Type: application/json; charset=UTF-8
```

#### Response body
```json
    {
        "id": 5,
        "url": "http:\/\/127.0.0.1:8080\/media\/image\/c8\/36\/c836eef9d5c393d35a6cbb048ddc4b1e.jpg",
        "preview":{"thumbnail":"http:\/\/127.0.0.1:8080\/media\/image\/c2\/2d\/c22dd7836bbeb635736cd4a7e96f9145.jpg"}
    }
```
