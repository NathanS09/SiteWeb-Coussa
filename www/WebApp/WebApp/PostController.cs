using Microsoft.AspNetCore.Mvc;
using System;
using System.Collections.Generic;
using System.Threading.Tasks;
using WebApp.Services;

namespace WebApp
{
public class PostsController : Controller
    {
        private readonly FacebookApiClient _facebookApiClient;


        public PostsController(FacebookApiClient facebookApiClient)
        {
            _facebookApiClient = facebookApiClient;
        }

        public async Task<IActionResult> Index()
        {
            Console.WriteLine("avant");
            string pageId = "355298635755665";
            List<FacebookPost> posts = await _facebookApiClient.GetLatestPosts(pageId);
            Console.WriteLine("fait " + posts.Count);

            foreach (var post in posts)
            {
                Console.WriteLine(post.Message);
            }

            return View(posts);
        }
    }
}


