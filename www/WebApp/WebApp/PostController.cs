using Microsoft.AspNetCore.Mvc;
using System;
using System.Collections.Generic;
using System.Threading.Tasks;
using WebApp.Services;

namespace WebApp
{
public class PostsController : Controller
    {
        public async Task<IActionResult> Index()
        {

            var pageUrl = "https://www.facebook.com/fc.c.hers";
            var scraper = new FacebookPageScraper();
            var posts = await scraper.GetLatestPosts(pageUrl, 3);
                Console.WriteLine("avant");

            foreach (var post in posts)
            {
                Console.WriteLine(post.Message);
            }

            return View(posts);
        }
    }
}


