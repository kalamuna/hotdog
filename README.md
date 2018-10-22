# Hot Dog/Not Hot Dog

Checks whether or not a given image is a hot dog, or not a hot dog.

## Install

1. Make sure the dependencies are available...
    - [git](https://git-scm.com)
    - [Composer](https://getcomposer.org)
    - [PHP](https://secure.php.net/) >= 7

2. Check out the repository and run `composer install`:
    ``` bash
    git clone https://github.com/kalamuna/hotdog.git
    cd hotdog
    ```

3. Install package dependencies with Composer:
    ```
    composer install
    ```

4. Visit the [Google Cloud Vision API](https://console.cloud.google.com/apis/library/vision.googleapis.com) and enable the API
    
5. Head over to the [Google Cloud Console Service Account Credentials](https://console.cloud.google.com/apis/credentials) and [create an API key](https://cloud.google.com/docs/authentication/api-keys#creating_an_api_key)
    
6. Export the JSON key to `.service_account.json`

8. Point your web server to the project's root, or use:
    ```
    composer start
    ```

## Usage

1. Visit http://localhost:8080
2. Upload an image
3. See that the image is either a hot dog, or not a hot dog
