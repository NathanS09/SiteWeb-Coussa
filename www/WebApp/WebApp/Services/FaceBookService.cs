using System;
using System.Collections.Generic;
using System.Net.Http;
using System.Threading.Tasks;
using Newtonsoft.Json;

namespace WebApp
{
    public class FacebookPost
    {
        public string Message { get; set; }
        public DateTime CreatedTime { get; set; }
    }

    public class FacebookPageResponse
    {
        public List<FacebookPost> Data { get; set; }
    }

    public class FacebookApiClient
    {
        private readonly HttpClient _httpClient;

        public FacebookApiClient()
        {
            _httpClient = new HttpClient();
        }

        public async Task<List<FacebookPost>> GetLatestPosts(string pageId, int limit = 3)
        {
            var accessToken = "EAAJi8SrMxssBAFMmWA8GcHkuIQYmXsbh4FosDP949CZAZBfKZB6E9JgPvpeceZBsxybMRd1Vmx20XYmocEIPPEB0ZCX6PCmZBPJJh2vh34qXFR89RSwCpiyZBTGsDnAtiLT3YQfeOPdZByzvRjCxJrV5yicy31vto8ea9ZBCY2Cfk8pRG1IT9vsRvPfb1lG1kxfntwiJCeUr02wZDZD";
            var apiUrl = $"https://graph.facebook.com/{pageId}/posts?limit={limit}&access_token={accessToken}";

            var response = await _httpClient.GetAsync(apiUrl);
            Console.WriteLine("ici");
            if (response.IsSuccessStatusCode)
            {
                Console.WriteLine("dedans");
                var content = await response.Content.ReadAsStringAsync();
                var pageResponse = JsonConvert.DeserializeObject<FacebookPageResponse>(content);
                return pageResponse?.Data;
            }

            return null;
        }
    }
}
